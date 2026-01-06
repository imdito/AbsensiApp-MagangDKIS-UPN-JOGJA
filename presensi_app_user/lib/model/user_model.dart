

class UserModel {
  int id;
  String nama;
  String divisi;
  String email;
  String nip;

  UserModel({
    required this.id,
    required this.nama,
    required this.divisi,
    required this.email,
    required this.nip,
  });

  // 1. Mengubah Map (JSON) menjadi Object
  factory UserModel.fromJson(Map<String, dynamic> json) {
    return UserModel(
      id: json['user_id'],
      nama: json['nama'],
      email: json['email'],
      divisi: json['divisi'],
      nip: json['NIP'],
    );
  }

  // 2. Mengubah Object menjadi Map (Untuk dikirim balik ke API)
  Map<String, dynamic> toJson() {
    return {
      'user_id': id,
      'nama': nama,
      'email': email,
      'divisi': divisi,
      'nip' : nip,
    };
  }

}