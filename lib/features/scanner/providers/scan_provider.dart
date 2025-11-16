import 'package:flutter/foundation.dart';
import '../services/verify_service.dart';

class ScanProvider extends ChangeNotifier {
  final VerifyService _service = VerifyService();

  bool isLoading = false;
  Map? result;

  Future<void> verify(String qr) async {
    isLoading = true;
    notifyListeners();

    result = await _service.verifyProduct(qr);

    isLoading = false;
    notifyListeners();
  }
}
