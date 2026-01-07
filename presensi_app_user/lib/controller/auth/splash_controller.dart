import 'dart:convert';
import 'package:get/get.dart';
import 'package:presensi_app_user/view/auth/login_page.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../../model/user_model.dart';
import '../../view/home_page.dart';

class SplashController extends GetxController {

  @override
  void onInit() {
    super.onInit();
    // Beri jeda sedikit (misal 2 detik) agar logo tampil, lalu cek login
    Future.delayed(const Duration(seconds: 2), () {
      checkLoginStatus();
    });
  }

  void checkLoginStatus() async {
    SharedPreferences prefs = await SharedPreferences.getInstance();

    // 1. Cek apakah ada token & data user
    String? token = prefs.getString('auth_token');
    String? userDataString = prefs.getString('user_data');

    if (token != null && userDataString != null) {
      // --- KONDISI SUDAH LOGIN ---

      try {
        // Balikin Data User dari String ke Object Model
        var userMap = jsonDecode(userDataString);
        UserModel user = UserModel.fromJson(userMap);

        // Langsung lompat ke Home tanpa Login lagi
        Get.offAll(() => const HomePage(), arguments: {
          'user': user,
          'token': token,
        });
      } catch (e) {
        // Jaga-jaga jika data corrupt, paksa login ulang
        Get.offAll(() => const LoginPage());
      }

    } else {
      // --- KONDISI BELUM LOGIN ---
      Get.offAll(() => const LoginPage());
    }
  }
}