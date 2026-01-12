import 'dart:convert';

import 'package:flutter/cupertino.dart';
import 'package:flutter_dotenv/flutter_dotenv.dart';
import 'package:get/get.dart';
import 'package:get/get_state_manager/src/simple/get_controllers.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../../model/user_model.dart';
import '../../view/home_page.dart';

class LoginController extends GetxController {
// Reactive variable (.obs) untuk visibility password
  var isObscure = true.obs;
  var isLoading = false.obs;
  var token = ''.obs;
  String baseUrl = dotenv.env['BASE_URL'] ?? 'fallback_url';
  // Text Controllers untuk mengambil input user
  final emailController = TextEditingController();
  final passwordController = TextEditingController();

  // Fungsi toggle hide/show password
  void togglePasswordVisibility() {
    isObscure.value = !isObscure.value;
  }

  // Fungsi Login
  Future<void> login() async {
    try {
      isLoading.value = true; // UI akan loading
      String email = emailController.text;
      String password = passwordController.text;
      var response = await http.post(
        Uri.parse('$baseUrl/api/login'),
        headers: {'Accept': 'application/json'},
        body: {
          'email': email,
          'password': password
        },
      );

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        var newToken = data['access_token'];
        var userjson = data['user'];
        print("data : $data" );
        //mengubah userjson menjadi usermodel
        UserModel user = UserModel.fromJson(userjson);

        // Simpan ke memory
        SharedPreferences prefs = await SharedPreferences.getInstance();
        await prefs.setString('auth_token', newToken);
        await prefs.setString('user_data', jsonEncode(userjson));
        // Update state token
        token.value = newToken;

        Get.snackbar("Sukses", "Login Berhasil",
            snackPosition: SnackPosition.BOTTOM, backgroundColor: Get.theme.primaryColorLight);
        dispose();
        Get.to(const HomePage(), arguments: {
          'user': user,
          'token': newToken,
        }); // Pindah ke Home & Hapus riwayat Login
      } else {
        Get.snackbar("Error", "Login Gagal. Cek email/password.",
            snackPosition: SnackPosition.BOTTOM, backgroundColor: Get.theme.colorScheme.error);
      }
    } catch (e) {
      Get.snackbar("Error", "Masalah koneksi: $e");
      print(e);
    } finally {
      isLoading.value = false; // Matikan loading
    }
  }

  @override
  void onClose() {
    // Bersihkan controller saat halaman ditutup untuk hemat memori
    emailController.dispose();
    passwordController.dispose();
    super.onClose();
  }

}