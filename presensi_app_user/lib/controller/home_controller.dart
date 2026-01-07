import 'package:get/get.dart';
import 'package:presensi_app_user/model/user_model.dart';
import 'package:presensi_app_user/view/scan_presensi_view.dart';
import 'package:shared_preferences/shared_preferences.dart';

import '../view/auth/login_page.dart';

class HomeController extends GetxController {

  UserModel user = Get.arguments['user'];
  late DateTime waktuSaatini;

  @override
  void onInit() {
    super.onInit();
    waktuSaatini = DateTime.now();
  }

  var jamMasuk = '08:00 AM'.obs;
  var jamPulang = '05:00 PM'.obs;

  // Navigasi
  void goToPresensi() {
    print("Navigasi ke Halaman Presensi/Scan QR");
    Get.to(() => ScanPresensiView(), arguments: user.id);
  }

  void goToEditProfile() {
    print("Navigasi ke Edit Profile");
    // Get.to(() => EditProfilePage());
  }

  void logout() {
    Get.defaultDialog(
        title: "Logout",
        middleText: "Apakah Anda yakin ingin keluar?",
        textConfirm: "Ya",
        textCancel: "Batal",
        confirmTextColor: Get.theme.scaffoldBackgroundColor, // White usually
        onConfirm: () async {
          SharedPreferences prefs = await SharedPreferences.getInstance();
          await prefs.clear(); // Hapus Token & Data User
          Get.offAll(() => const LoginPage());
        }
    );
  }

  String statusHari(){

    if(waktuSaatini.hour < 9){
      return "Pagi";
    } else if(waktuSaatini.hour < 15){
      return "Siang";
    } else if(waktuSaatini.hour < 18){
      return "Sore";
    } else {
      return "Malam";
    }

  }

}