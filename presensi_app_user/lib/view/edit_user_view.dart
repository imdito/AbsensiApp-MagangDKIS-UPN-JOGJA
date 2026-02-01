import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:google_fonts/google_fonts.dart';
import '../controller/edit_user_controller.dart';
import '../model/user_model.dart'; // Pastikan import controller benar

class EditUserView extends StatelessWidget {
  final UserModel user;
  const EditUserView({Key? key, required this.user}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final controller = Get.put(EditUserController(userModel: user));

    // Warna Tema (Sesuai HomePage kamu)
    const Color primaryColor = Color(0xFF4F46E5);
    const Color grayBg = Color(0xFFF9FAFB);
    const Color textDark = Color(0xFF1F2937);

    return Scaffold(
      backgroundColor: grayBg,
      body: SingleChildScrollView(
        child: Column(
          children: [
            // --- HEADER ---
            Container(
              padding: const EdgeInsets.fromLTRB(24, 50, 24, 30),
              decoration: const BoxDecoration(
                color: primaryColor,
                borderRadius: BorderRadius.only(
                  bottomLeft: Radius.circular(32),
                  bottomRight: Radius.circular(32),
                ),
              ),
              child: Column(
                children: [
                  Row(
                    children: [
                      // Tombol Back Custom
                      Container(
                        decoration: BoxDecoration(
                          color: Colors.white.withOpacity(0.2),
                          borderRadius: BorderRadius.circular(12),
                        ),
                        child: IconButton(
                          icon: const Icon(Icons.arrow_back_ios_new_rounded, color: Colors.white, size: 18),
                          onPressed: () => Get.back(),
                        ),
                      ),
                      const SizedBox(width: 16),
                      Text(
                        "Edit Profil",
                        style: GoogleFonts.inter(
                          color: Colors.white,
                          fontSize: 20,
                          fontWeight: FontWeight.bold,
                        ),
                      ),
                    ],
                  ),
                  const SizedBox(height: 30),

                  // Avatar Besar di Tengah Header
                  Stack(
                    alignment: Alignment.bottomRight,
                    children: [
                      Container(
                        padding: const EdgeInsets.all(4),
                        decoration: BoxDecoration(
                          color: Colors.white.withOpacity(0.2),
                          shape: BoxShape.circle,
                        ),
                        child: CircleAvatar(
                          radius: 45,
                          backgroundColor: Colors.white,
                          child: Text(
                            user.nama[0],
                            style: GoogleFonts.inter(
                                fontSize: 32,
                                fontWeight: FontWeight.bold,
                                color: primaryColor
                            ),
                          ),
                        ),
                      ),
                      Container(
                        padding: const EdgeInsets.all(6),
                        decoration: const BoxDecoration(
                          color: Colors.amber, // Aksen warna beda dikit biar pop
                          shape: BoxShape.circle,
                        ),
                        child: const Icon(Icons.edit, color: Colors.white, size: 16),
                      )
                    ],
                  ),
                ],
              ),
            ),

            // --- FORM SECTION ---
            Padding(
              padding: const EdgeInsets.symmetric(horizontal: 24, vertical: 24),
              child: Form(
                key: controller.formKey,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    _buildSectionTitle("Informasi Pribadi"),

                    // NIP (Readonly Style)
                    _buildReadOnlyCard("NIP Pegawai", controller.nipC.text, Icons.badge_rounded),

                    const SizedBox(height: 16),

                    // Nama Lengkap
                    _buildReadOnlyCard(
                       "Nama Lengkap",
                      controller.namaC.text,
                      Icons.person_rounded,
                    ),

                    const SizedBox(height: 16),

                    // Email
                    _buildInputCard(
                      label: "Alamat Email",
                      controller: controller.emailC,
                      icon: Icons.email_rounded,
                      primaryColor: primaryColor,
                      inputType: TextInputType.emailAddress,
                    ),

                    const SizedBox(height: 24),
                    _buildSectionTitle("Keamanan"),

                    // Password
                    _buildInputCard(
                      label: "Password Baru (Opsional)",
                      controller: controller.passwordC,
                      icon: Icons.lock_rounded,
                      primaryColor: primaryColor,
                      isPassword: true,
                      placeholder: "Kosongkan jika tidak diganti",
                    ),

                    const SizedBox(height: 40),

                    // --- SAVE BUTTON (Hero Style) ---
                    Obx(() => InkWell(
                      onTap: controller.isLoading.value ? null : () => controller.updateUser(),
                      borderRadius: BorderRadius.circular(20),
                      child: Container(
                        width: double.infinity,
                        padding: const EdgeInsets.symmetric(vertical: 18),
                        decoration: BoxDecoration(
                          color: primaryColor,
                          borderRadius: BorderRadius.circular(20),
                          boxShadow: [
                            BoxShadow(
                              color: primaryColor.withOpacity(0.4),
                              blurRadius: 20,
                              offset: const Offset(0, 10),
                            ),
                          ],
                        ),
                        child: Center(
                          child: controller.isLoading.value
                              ? const SizedBox(
                              height: 24,
                              width: 24,
                              child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2)
                          )
                              : Text(
                            "SIMPAN PERUBAHAN",
                            style: GoogleFonts.inter(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                              color: Colors.white,
                              letterSpacing: 0.5,
                            ),
                          ),
                        ),
                      ),
                    )),

                    const SizedBox(height: 30),
                  ],
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  // --- WIDGET BUILDERS ---

  Widget _buildSectionTitle(String title) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12, left: 4),
      child: Text(
        title,
        style: GoogleFonts.inter(
          fontSize: 12,
          fontWeight: FontWeight.bold,
          color: Colors.grey.shade500,
          letterSpacing: 1.2,
        ),
      ),
    );
  }

  // Card putih polos untuk data Readonly (NIP)
  Widget _buildReadOnlyCard(String label, String value, IconData icon) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.grey.shade100,
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: Colors.grey.shade200),
      ),
      child: Row(
        children: [
          Icon(icon, color: Colors.grey.shade400, size: 24),
          const SizedBox(width: 16),
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(label, style: GoogleFonts.inter(fontSize: 10, color: Colors.grey.shade500)),
              Text(value, style: GoogleFonts.inter(fontSize: 15, fontWeight: FontWeight.bold, color: Colors.grey.shade600)),
            ],
          ),
          const Spacer(),
          const Icon(Icons.lock_outline, size: 16, color: Colors.grey),
        ],
      ),
    );
  }

  // Card Input (TextField)
  Widget _buildInputCard({
    required String label,
    required TextEditingController controller,
    required IconData icon,
    required Color primaryColor,
    TextInputType inputType = TextInputType.text,
    bool isPassword = false,
    String? placeholder,
  }) {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(16),
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.04),
            blurRadius: 10,
            offset: const Offset(0, 4),
          ),
        ],
      ),
      child: TextFormField(
        controller: controller,
        obscureText: isPassword,
        keyboardType: inputType,
        style: GoogleFonts.inter(fontWeight: FontWeight.w600, color: const Color(0xFF1F2937)),
        decoration: InputDecoration(
          icon: Container(
            padding: const EdgeInsets.all(8),
            decoration: BoxDecoration(
              color: primaryColor.withOpacity(0.1),
              borderRadius: BorderRadius.circular(10),
            ),
            child: Icon(icon, color: primaryColor, size: 20),
          ),
          border: InputBorder.none,
          labelText: label,
          hintText: placeholder,
          hintStyle: GoogleFonts.inter(fontSize: 12, color: Colors.grey.shade400),
          labelStyle: GoogleFonts.inter(fontSize: 13, color: Colors.grey.shade500),
          floatingLabelStyle: GoogleFonts.inter(color: primaryColor, fontWeight: FontWeight.bold),
        ),
      ),
    );
  }
}