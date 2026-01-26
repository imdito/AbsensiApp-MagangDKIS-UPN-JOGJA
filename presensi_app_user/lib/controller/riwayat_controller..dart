import 'package:flutter/material.dart';
import 'package:get/get.dart';
import '../model/presensi_model.dart';
import '../services/presensi_api_service.dart';

class RiwayatController extends GetxController {
  var selectedMonth = DateTime.now().obs;
  var riwayatList = <PresensiModel>[].obs;
  final userId = Get.arguments['user_id'];
  var isLoading = false.obs;
  final PresensiApiService presensiApiService = PresensiApiService();

  // --- Computed Properties (Hitung otomatis saat data berubah) ---
  int get hadirCount => riwayatList.where((e) => e.status == 'Hadir').length;
  int get terlambatCount => riwayatList.where((e) => e.status == 'Terlambat').length;
  int get absenCount => riwayatList.where((e) => ['Izin', 'Sakit', 'Alpha'].contains(e.status)).length;

  @override
  void onInit() {
    super.onInit();
    fetchRiwayat(); // Load data awal
  }

  // --- Logic: Fetch Data (API) ---
  void fetchRiwayat() async {
    isLoading.value = true;

    var data = await presensiApiService.fetchRiwayatPresensi(userId: userId);

    riwayatList.assignAll(data);

    isLoading.value = false;
  }

  // --- Logic: Ganti Bulan ---
  void pickDate(BuildContext context) async {
    final DateTime? picked = await showDatePicker(
      context: context,
      initialDate: selectedMonth.value,
      firstDate: DateTime(2020),
      lastDate: DateTime.now(),
      builder: (context, child) {
        return Theme(
          data: ThemeData.light().copyWith(
            colorScheme: const ColorScheme.light(primary: Colors.blue),
          ),
          child: child!,
        );
      },
    );

    if (picked != null && picked != selectedMonth.value) {
      selectedMonth.value = picked;
      fetchRiwayat(); // Reload data sesuai bulan baru
    }
  }

  // --- Helper: Warna Status ---
  Color getStatusColor(String status) {
    switch (status.toLowerCase()) {
      case 'hadir': return Colors.green;
      case 'terlambat': return Colors.orange;
      case 'sakit':
      case 'izin': return Colors.blue;
      default: return Colors.grey;
    }
  }
}