import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:presensi_app_user/services/update_user_service.dart';
import '../model/user_model.dart';

class EditUserController extends GetxController {
  final UserModel userModel;
  EditUserController({required this.userModel});

  // --- REACTIVE VARIABLES (OBS) ---
  var isLoading = false.obs;
  var listBidang = <Map<String, dynamic>>[].obs; // Nanti diisi dari API

  RxnString selectedJabatan = RxnString();
  RxnInt selectedBidangId = RxnInt();

  // Text Controllers (Tidak perlu .obs)
  late TextEditingController nipC;
  late TextEditingController namaC;
  late TextEditingController emailC;
  late TextEditingController passwordC;

  GlobalKey<FormState> formKey = GlobalKey<FormState>();

  @override
  void onInit() {
    super.onInit();
    // 1. Setup Data Awal (Pre-fill)
    nipC = TextEditingController(text: userModel.nip);
    namaC = TextEditingController(text: userModel.nama);
    emailC = TextEditingController(text: userModel.email);
    passwordC = TextEditingController(); // Kosongkan password
  }

  @override
  void onClose() {
    // Bersihkan memori controller
    nipC.dispose();
    namaC.dispose();
    emailC.dispose();
    passwordC.dispose();
    super.onClose();
  }

  // --- LOGIC FUNCTIONS ---

  Future<void> updateUser() async {
    if (!formKey.currentState!.validate()) return;

    isLoading.value = true;

    try {
      // Siapkan data body
      Map<String, dynamic> data = {
        'name': namaC.text,
        'email': emailC.text,
      };

      // Hanya kirim password jika diisi
      if (passwordC.text.isNotEmpty) {
        data['password'] = passwordC.text;
      }

      //memanggil service update user
      UpdateUserService updateUserService = UpdateUserService();
      var Response =  await updateUserService.updateUserApi(data);
      print("Response update user: ${Response.body}");


      // Feedback & Navigasi
      Get.snackbar(
          "Berhasil",
          "Data pegawai berhasil diperbarui",
          backgroundColor: Colors.green,
          colorText: Colors.white,
          snackPosition: SnackPosition.BOTTOM
      );

      // Kembali ke halaman sebelumnya & kirim sinyal refresh
      Get.back(result: true);

    } catch (e) {
      print("Error update user: $e");
      Get.snackbar(
          "Error",
          "Gagal update data: $e",
          backgroundColor: Colors.red,
          colorText: Colors.white
      );
    } finally {
      isLoading.value = false;
    }
  }
}