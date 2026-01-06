import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import '../controller/scan_presensi_controller.dart';

class ScanPresensiView extends StatelessWidget {
  const ScanPresensiView({super.key});

  @override
  Widget build(BuildContext context) {
    // Controller bawaan dari library untuk mengatur flash/kamera
    final MobileScannerController cameraController = MobileScannerController();
    final controller = Get.put(ScanPresensiController());
    return Scaffold(
      extendBodyBehindAppBar: true,
      appBar: AppBar(
        title: const Text("Scan Presensi", style: TextStyle(color: Colors.white)),
        backgroundColor: Colors.transparent,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Colors.white),
          onPressed: () => Get.back(),
        ),
        actions: [
          IconButton(
            color: Colors.white,
            icon: ValueListenableBuilder(
              valueListenable: controller.cameraController,
              builder: (context, state, child) {
                switch (state.torchState) {
                  case TorchState.off:
                    return const Icon(Icons.flash_off, color: Colors.grey);
                  case TorchState.on:
                    return const Icon(Icons.flash_on, color: Colors.yellow);
                  case TorchState.auto: // Tambahan: mode auto (jika ada)
                    return const Icon(Icons.flash_auto, color: Colors.white);
                  case TorchState.unavailable: // Tambahan: jika HP tidak punya flash
                    return const Icon(Icons.no_flash, color: Colors.grey);
                }
              },
            ),
            onPressed: () => controller.toggleFlash(),
          ),
        ],
      ),
      body: Stack(
        children: [
          // LAPISAN 1: Kamera Scanner
          MobileScanner(
            controller: cameraController,
            onDetect: (capture) {
              final List<Barcode> barcodes = capture.barcodes;
              for (final barcode in barcodes) {
                // Nanti logika backend ditaruh di sini
                debugPrint('QR Code ditemukan: ${barcode.rawValue}');
              }
            },
          ),

          // LAPISAN 2: Overlay Gelap & Kotak Fokus
          // Kita gunakan ColorFiltered untuk membuat efek "bolong" di tengah
          ColorFiltered(
            colorFilter: ColorFilter.mode(
              // Warna background gelap transparan (opacity 0.7)
              Colors.black.withOpacity(0.7),
              BlendMode.srcOut,
            ),
            child: Stack(
              fit: StackFit.expand,
              children: [
                // Background yang akan "dilubangi"
                Container(
                  decoration: const BoxDecoration(
                    color: Colors.black,
                    backgroundBlendMode: BlendMode.dstOut,
                  ),
                ),
                // Lubang Kotak di tengah (Area Scan)
                Align(
                  alignment: Alignment.center,
                  child: Container(
                    height: 280,
                    width: 280,
                    decoration: BoxDecoration(
                      color: Colors.red, // Warna ini akan menjadi transparan karena srcOut
                      borderRadius: BorderRadius.circular(20),
                    ),
                  ),
                ),
              ],
            ),
          ),

          // LAPISAN 3: Border Putih & Teks (Hiasan)
          Align(
            alignment: Alignment.center,
            child: Container(
              height: 280,
              width: 280,
              decoration: BoxDecoration(
                // Border garis putih di sekeliling kotak scan
                border: Border.all(color: Colors.white, width: 3),
                borderRadius: BorderRadius.circular(20),
              ),
            ),
          ),

          // Teks Instruksi di bawah kotak
          Positioned(
            bottom: 100,
            left: 0,
            right: 0,
            child: Column(
              children: [
                Text(
                  "Arahkan QR Code ke dalam kotak",
                  style: TextStyle(
                    color: Colors.white.withOpacity(0.9),
                    fontSize: 16,
                    fontWeight: FontWeight.w500,
                  ),
                ),
                const SizedBox(height: 8),
                const Text(
                  "Scanning...",
                  style: TextStyle(
                    color: Colors.blueAccent,
                    fontSize: 14,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}