import 'package:get/get.dart';

class HomeController extends GetxController {
  // Data User Dummy (Nanti diambil dari API/Storage)
  var userName = "Pandito Setiawan".obs;
  var userDivision = "Mobile Developer".obs;

  // Data Presensi Hari Ini (Dummy)
  var jamMasuk = "07:45".obs;
  var jamPulang = "--:--".obs;

  // Navigasi
  void goToPresensi() {
    print("Navigasi ke Halaman Presensi/Scan QR");
    // Get.to(() => PresensiPage());
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