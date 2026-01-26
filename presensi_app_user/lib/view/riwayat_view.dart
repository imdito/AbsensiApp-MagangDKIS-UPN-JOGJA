import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:intl/intl.dart';
import '../controller/riwayat_controller..dart';
import '../model/presensi_model.dart';

class RiwayatView extends StatelessWidget {
  const RiwayatView({super.key});

  @override
  Widget build(BuildContext context) {
    // Inject Controller
    final controller = Get.put(RiwayatController());

    return Scaffold(
      backgroundColor: Colors.grey[100],
      appBar: AppBar(
        title: const Text("Riwayat Presensi", style: TextStyle(color: Colors.black, fontWeight: FontWeight.bold)),
        backgroundColor: Colors.white,
        elevation: 0,
        centerTitle: true,
        actions: [
          IconButton(
            icon: const Icon(Icons.calendar_month, color: Colors.black),
            onPressed: () => controller.pickDate(context),
          )
        ],
      ),
      body: Column(
        children: [
          // Header Summary (Dibungkus Obx karena angkanya berubah-ubah)
          Obx(() => _buildHeaderSummary(controller)),

          // Selector Bulan (Dibungkus Obx karena bulannya bisa berubah)
          Obx(() => _buildMonthSelector(controller)),

          // List Data (Dibungkus Obx untuk loading & list update)
          Expanded(
            child: Obx(() {
              if (controller.isLoading.value) {
                return const Center(child: CircularProgressIndicator());
              }

              if (controller.riwayatList.isEmpty) {
                return const Center(child: Text("Tidak ada data presensi."));
              }

              return ListView.builder(
                padding: const EdgeInsets.all(16),
                itemCount: controller.riwayatList.length,
                itemBuilder: (context, index) {
                  final item = controller.riwayatList[index];
                  return _buildPresensiCard(item, controller);
                },
              );
            }),
          ),
        ],
      ),
    );
  }

  // --- Widget: Header Summary ---
  Widget _buildHeaderSummary(RiwayatController controller) {
    return Container(
      padding: const EdgeInsets.all(20),
      decoration: const BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.only(
          bottomLeft: Radius.circular(24),
          bottomRight: Radius.circular(24),
        ),
        boxShadow: [BoxShadow(color: Colors.black12, blurRadius: 10, offset: Offset(0, 5))],
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceAround,
        children: [
          _buildStatItem("Hadir", "${controller.hadirCount}", Colors.green),
          _buildStatItem("Terlambat", "${controller.terlambatCount}", Colors.orange),
          _buildStatItem("Absen", "${controller.absenCount}", Colors.red),
        ],
      ),
    );
  }

  Widget _buildStatItem(String label, String count, Color color) {
    return Column(
      children: [
        Text(count, style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold, color: color)),
        const SizedBox(height: 4),
        Text(label, style: const TextStyle(fontSize: 12, color: Colors.grey, fontWeight: FontWeight.w500)),
      ],
    );
  }

  // --- Widget: Selector Bulan ---
  Widget _buildMonthSelector(RiwayatController controller) {
    return Padding(
      padding: const EdgeInsets.fromLTRB(16, 20, 16, 5),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Text(
            DateFormat('MMMM yyyy', 'id_ID').format(controller.selectedMonth.value),
            style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.black87),
          ),
          Text(
            "${controller.riwayatList.length} Hari Kerja",
            style: TextStyle(fontSize: 12, color: Colors.grey[600]),
          ),
        ],
      ),
    );
  }

  // --- Widget: Card Item List ---
  Widget _buildPresensiCard(PresensiModel data, RiwayatController controller) {
    Color statusColor = controller.getStatusColor(data.status);
    Color statusBgColor = statusColor.withOpacity(0.1);

    return Container(
      margin: const EdgeInsets.only(bottom: 16),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [BoxShadow(color: Colors.grey.withOpacity(0.1), blurRadius: 6, offset: const Offset(0, 3))],
      ),
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Row(
          children: [
            // Kolom Tanggal
            Container(
              width: 50,
              decoration: BoxDecoration(
                color: Colors.blue.withOpacity(0.05),
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.symmetric(vertical: 10),
              child: Column(
                children: [
                  Text(DateFormat('dd').format(data.tanggal), style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: Colors.blue)),
                  Text(DateFormat('EEE').format(data.tanggal), style: const TextStyle(fontSize: 12, color: Colors.blue)),
                ],
              ),
            ),
            const SizedBox(width: 16),

            // Kolom Jam
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Row(children: [
                    const Icon(Icons.login, size: 16, color: Colors.green),
                    const SizedBox(width: 6),
                    Text(data.jamMasuk ?? '--:--', style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w600)),
                  ]),
                  const SizedBox(height: 8),
                ],
              ),
            ),

            // Status Badge
            Container(
              padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
              decoration: BoxDecoration(color: statusBgColor, borderRadius: BorderRadius.circular(20)),
              child: Text(data.status, style: TextStyle(color: statusColor, fontSize: 12, fontWeight: FontWeight.bold)),
            ),
          ],
        ),
      ),
    );
  }
}