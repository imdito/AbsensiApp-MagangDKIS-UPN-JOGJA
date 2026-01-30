import 'package:flutter_test/flutter_test.dart';
import 'package:presensi_app_user/model/presensi_model.dart';

void main() {
  group('PresensiModel Tests', () {
    test('should create PresensiModel with all required fields', () {
      // Arrange
      final tanggal = DateTime(2026, 1, 27);

      // Act
      final presensi = PresensiModel(
        id: '1',
        tanggal: tanggal,
        jamMasuk: '08:00',
        status: 'Hadir',
      );

      // Assert
      expect(presensi.id, '1');
      expect(presensi.tanggal, tanggal);
      expect(presensi.jamMasuk, '08:00');
      expect(presensi.status, 'Hadir');
    });

    test('should create PresensiModel without optional jamMasuk', () {
      // Arrange
      final tanggal = DateTime(2026, 1, 27);

      // Act
      final presensi = PresensiModel(
        id: '2',
        tanggal: tanggal,
        status: 'Alpha',
      );

      // Assert
      expect(presensi.id, '2');
      expect(presensi.tanggal, tanggal);
      expect(presensi.jamMasuk, null);
      expect(presensi.status, 'Alpha');
    });

    test('should support different status values', () {
      // Arrange
      final tanggal = DateTime(2026, 1, 27);
      final statuses = ['Hadir', 'Terlambat', 'Izin', 'Sakit', 'Alpha'];

      // Act & Assert
      for (var status in statuses) {
        final presensi = PresensiModel(
          id: '1',
          tanggal: tanggal,
          jamMasuk: '08:00',
          status: status,
        );

        expect(presensi.status, status);
      }
    });
  });
}

