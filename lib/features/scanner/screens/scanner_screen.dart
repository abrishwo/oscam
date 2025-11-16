import 'package:flutter/material.dart';
import 'package:mobile_scanner/mobile_scanner.dart';
import 'package:provider/provider.dart';
import '../providers/scan_provider.dart';
import '../widgets/shine_effect.dart';

class ScannerScreen extends StatefulWidget {
  @override
  _ScannerScreenState createState() => _ScannerScreenState();
}

class _ScannerScreenState extends State<ScannerScreen> {
  bool isProcessing = false;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          /// CAMERA SCANNER
          MobileScanner(
            allowDuplicates: false,
            onDetect: (capture) async {
              if (isProcessing) return;
              isProcessing = true;

              final qr = capture.barcodes.first.rawValue;
              if (qr != null) {
                await Provider.of<ScanProvider>(context, listen: false)
                    .verify(qr);

                await Future.delayed(Duration(seconds: 1));
                isProcessing = false;
              }
            },
          ),

          /// UI OVERLAY
          Consumer<ScanProvider>(
            builder: (context, scan, _) {
              if (scan.isLoading) {
                return Center(
                  child: CircularProgressIndicator(),
                );
              }

              if (scan.result != null) {
                final status = scan.result!['status'];

                if (status == "original") {
                  return Center(
                    child: ShineEffect(text: "ORIGINAL PRODUCT ✔"),
                  );
                }

                if (status == "suspicious") {
                  return Center(
                    child: Text(
                      "Possible Clone ⚠",
                      style: TextStyle(fontSize: 24, color: Colors.orange),
                    ),
                  );
                }

                return Center(
                  child: Text(
                    "FAKE PRODUCT ❌",
                    style: TextStyle(fontSize: 24, color: Colors.red),
                  ),
                );
              }

              return SizedBox.shrink();
            },
          ),
        ],
      ),
    );
  }
}
