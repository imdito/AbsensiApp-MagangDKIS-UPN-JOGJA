import 'package:get/get.dart';
import 'package:presensi_app_user/model/user_model.dart';
import 'package:presensi_app_user/view/scan_presensi_view.dart';

class HomeController extends GetxController {

  UserModel user = Get.arguments['user'];

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
        onConfirm: () {
          print("Proses Logout...");
          // Get.offAll(() => LoginPage());
        }
    );
  }
}