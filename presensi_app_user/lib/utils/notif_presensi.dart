import 'package:flutter/material.dart';

void showFloatingNotif(BuildContext context, String message, bool isSuccess) {
  ScaffoldMessenger.of(context).showSnackBar(
    SnackBar(
      // Isi konten (Icon + Teks)
      content: Row(
        children: [
          Icon(
            isSuccess ? Icons.check_circle_outline : Icons.error_outline,
            color: Colors.white,
            size: 28,
          ),
          SizedBox(width: 12),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              mainAxisSize: MainAxisSize.min,
              children: [
                Text(
                  isSuccess ? "Berhasil!" : "Gagal!",
                  style: TextStyle(
                    fontWeight: FontWeight.bold,
                    fontSize: 16,
                  ),
                ),
                Text(
                  message,
                  style: TextStyle(fontSize: 14),
                  overflow: TextOverflow.ellipsis,
                  maxLines: 2,
                ),
              ],
            ),
          ),
        ],
      ),

      // Styling agar "Mengambang"
      backgroundColor: isSuccess ? Colors.green.shade600 : Colors.red.shade600,
      behavior: SnackBarBehavior.floating, // INI KUNCINYA
      elevation: 4, // Efek bayangan
      margin: EdgeInsets.all(20), // Jarak dari pinggir layar
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12), // Sudut melengkung
      ),
      duration: Duration(seconds: 3), // Lama muncul
    ),
  );
}