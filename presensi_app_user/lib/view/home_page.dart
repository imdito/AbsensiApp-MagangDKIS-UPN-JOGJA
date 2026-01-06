import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import '../controller/home_controller.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    //  Controller
    final HomeController controller = Get.put(HomeController());
    // Warna Tema
    const Color primaryColor = Color(0xFF4F46E5); // Indigo 600
    const Color secondaryColor = Color(0xFFEEF2FF); // Indigo 50
    const Color grayBg = Color(0xFFF9FAFB);
    const Color grayText = Color(0xFF6B7280);

    return Scaffold(
      backgroundColor: grayBg,
      body: SingleChildScrollView(
        child: Column(
          children: [
            // --- HEADER SECTION ---
            Container(
              padding: const EdgeInsets.fromLTRB(24, 60, 24, 40),
              decoration: const BoxDecoration(
                color: primaryColor,
                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(32),
                  bottomRight: Radius.circular(32),
                ),
              ),
              child: Column(
                children: [
                  // Top Bar (Profile & Logout)
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            'Halo, Selamat Pagi',
                            style: GoogleFonts.inter(
                              color: Colors.white70,
                              fontSize: 14,
                            ),
                          ),
                          const SizedBox(height: 4),
                          Text(
                            controller.user.nama,
                            style: GoogleFonts.inter(
                              color: Colors.white,
                              fontSize: 20,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          Text(
                            controller.user.divisi,
                            style: GoogleFonts.inter(
                              color: Colors.indigo.shade200,
                              fontSize: 12,
                            ),
                          )
                        ],
                      ),
                      // Logout Icon Button
                      Container(
                        decoration: BoxDecoration(
                          color: Colors.white.withOpacity(0.2),
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: IconButton(
                          icon: const Icon(Icons.logout, color: Colors.white),
                          onPressed: () => controller.logout(),
                        ),
                      )
                    ],
                  ),
                ],
              ),
            ),

            // --- ATTENDANCE STATUS CARD (Floating) ---
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24),
              child: Transform.translate(
                offset: const Offset(0, -30), // Efek overlap ke atas
                child: Container(
                  padding: const EdgeInsets.all(20),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(20),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.black.withOpacity(0.05),
                        blurRadius: 20,
                        offset: const Offset(0, 10),
                      ),
                    ],
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceAround,
                    children: [
                      _buildStatusItem("Jam Masuk", controller.jamMasuk.value, Icons.login, Colors.green),
                      Container(width: 1, height: 40, color: Colors.grey.shade200),
                      _buildStatusItem("Jam Pulang", controller.jamPulang.value, Icons.logout, Colors.orange),
                    ],
                  ),
                ),
              ),
            ),

            // --- MENU GRID ---
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    "Menu Utama",
                    style: GoogleFonts.inter(
                      fontSize: 18,
                      fontWeight: FontWeight.bold,
                      color: const Color(0xFF111827),
                    ),
                  ),
                  const SizedBox(height: 16),

                  // Grid Layout
                  GridView.count(
                    shrinkWrap: true,
                    physics: const NeverScrollableScrollPhysics(),
                    crossAxisCount: 2,
                    crossAxisSpacing: 16,
                    mainAxisSpacing: 16,
                    childAspectRatio: 1.1, // Mengatur rasio lebar:tinggi kartu
                    children: [

                      // 1. Menu PRESENSI (Main Feature)
                      _buildMenuCard(
                        title: "Presensi",
                        icon: Icons.qr_code_scanner,
                        color: primaryColor,
                        onTap: controller.goToPresensi,
                        isPrimary: true, // Highlighted
                      ),

                      // 2. Menu EDIT PROFILE
                      _buildMenuCard(
                        title: "Edit Profil",
                        icon: Icons.person_outline,
                        color: Colors.blueAccent,
                        onTap: controller.goToEditProfile,
                      ),

                      // 3. Menu RIWAYAT (Tambahan agar grid seimbang)
                      _buildMenuCard(
                        title: "Riwayat",
                        icon: Icons.history,
                        color: Colors.teal,
                        onTap: () {},
                      ),

                      // 4. Menu IZIN / SAKIT (Tambahan)
                      _buildMenuCard(
                        title: "Pengajuan Izin",
                        icon: Icons.note_alt_outlined,
                        color: Colors.orange,
                        onTap: () {},
                      ),
                    ],
                  ),
                ],
              ),
            ),

            const SizedBox(height: 30),
          ],
        ),
      ),
    );
  }

  // Widget Helper: Item Status (Jam Masuk/Pulang)
  Widget _buildStatusItem(String label, String time, IconData icon, Color color) {
    return Column(
      children: [
        Container(
          padding: const EdgeInsets.all(8),
          decoration: BoxDecoration(
            color: color.withOpacity(0.1),
            shape: BoxShape.circle,
          ),
          child: Icon(icon, color: color, size: 20),
        ),
        const SizedBox(height: 8),
        Text(
          time,
          style: GoogleFonts.inter(
            fontSize: 16,
            fontWeight: FontWeight.bold,
            color: const Color(0xFF111827),
          ),
        ),
        Text(
          label,
          style: GoogleFonts.inter(
            fontSize: 12,
            color: Colors.grey.shade500,
          ),
        ),
      ],
    );
  }

  // Widget Helper: Menu Card
  Widget _buildMenuCard({
    required String title,
    required IconData icon,
    required Color color,
    required VoidCallback onTap,
    bool isPrimary = false,
  }) {
    return InkWell(
      onTap: onTap,
      borderRadius: BorderRadius.circular(20),
      child: Container(
        decoration: BoxDecoration(
          color: isPrimary ? color : Colors.white,
          borderRadius: BorderRadius.circular(20),
          border: isPrimary ? null : Border.all(color: Colors.grey.shade100),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.03),
              blurRadius: 10,
              offset: const Offset(0, 4),
            ),
          ],
        ),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              padding: const EdgeInsets.all(12),
              decoration: BoxDecoration(
                color: isPrimary ? Colors.white.withOpacity(0.2) : color.withOpacity(0.1),
                borderRadius: BorderRadius.circular(16),
              ),
              child: Icon(
                icon,
                size: 32,
                color: isPrimary ? Colors.white : color,
              ),
            ),
            const SizedBox(height: 12),
            Text(
              title,
              style: GoogleFonts.inter(
                fontSize: 14,
                fontWeight: isPrimary ? FontWeight.w600 : FontWeight.w500,
                color: isPrimary ? Colors.white : const Color(0xFF374151),
              ),
            ),
          ],
        ),
      ),
    );
  }
}