import 'package:geolocator/geolocator.dart';

class LocationService {
  static const double officeLat = -6.726165636819541;
  static const double officeLong = 108.53908084087455;
  static const double maxDistanceMeters = 50.0;

  /// Mengambil posisi. Jika gagal, akan melempar Exception (Error).
  Future<Position> getCurrentLocation() async {
    bool serviceEnabled;
    LocationPermission permission;

    // 1. Cek GPS
    serviceEnabled = await Geolocator.isLocationServiceEnabled();
    if (!serviceEnabled) {
      // JANGAN pakai Get.snackbar di sini. Throw error saja.
      return Future.error('GPS belum aktif. Mohon nyalakan GPS Anda.');
    }

    // 2. Cek Permission
    permission = await Geolocator.checkPermission();
    if (permission == LocationPermission.denied) {
      permission = await Geolocator.requestPermission();
      if (permission == LocationPermission.denied) {
        return Future.error('Izin lokasi ditolak.');
      }
    }

    if (permission == LocationPermission.deniedForever) {
      // Kita bisa return error khusus agar Controller bisa arahkan ke settings
      return Future.error('location_denied_forever');
    }

    if (await Geolocator.isLocationServiceEnabled()) {
      Position position = await Geolocator.getCurrentPosition();
      if (position.isMocked) {
        return Future.error("Peringatan, Terdeteksi menggunakan lokasi palsu!");
      }
    }
    // 3. Ambil Posisi
    return await Geolocator.getCurrentPosition(
      desiredAccuracy: LocationAccuracy.high,
    );
  }

  double getDistanceFromOffice(double userLat, double userLong) {
    return Geolocator.distanceBetween(userLat, userLong, officeLat, officeLong);
  }

  bool isWithinOfficeRadius(double distance) {
    return distance <= maxDistanceMeters;
  }
}