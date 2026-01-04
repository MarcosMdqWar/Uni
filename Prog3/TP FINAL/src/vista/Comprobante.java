package vista;

import javax.swing.*;
import java.awt.*;
import java.awt.print.*;

/**
 * @author Marcos Joel Depaula
 * 
 * Genera un comprobante de pago cuando se agregar una orden de compra [!].
 * 
 */

public class Comprobante extends JFrame implements Printable {
    private JTextArea comprobanteTextArea;

    public Comprobante(String fecha, int idProd, int idCli, int cantidad, double total) {
        setTitle("Comprobante de Pago");
        setSize(400, 300);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        setLayout(new BorderLayout());

        comprobanteTextArea = new JTextArea();
        comprobanteTextArea.setEditable(false);
        comprobanteTextArea.setText(generarTextoComprobante(fecha, idProd, idCli, cantidad, total));

        JScrollPane scrollPane = new JScrollPane(comprobanteTextArea);
        add(scrollPane, BorderLayout.CENTER);

        JButton imprimirButton = new JButton("Imprimir");
        imprimirButton.addActionListener(e -> imprimirComprobante());
        add(imprimirButton, BorderLayout.SOUTH);
    }
    private String generarTextoComprobante(String fecha, int id_prod, int id_cli, int cantidad, double total) {
        StringBuilder sb = new StringBuilder();
        sb.append("Comprobante de Pago\n");
        sb.append("====================\n");
        sb.append("Fecha: ").append(fecha).append("\n");
        sb.append("ID Producto: ").append(id_prod).append("\n");
        sb.append("ID Cliente: ").append(id_cli).append("\n");
        sb.append("Cantidad: ").append(cantidad).append("\n");
        sb.append("Total: $").append(total).append("\n");
        sb.append("====================\n");
        sb.append("Gracias por su compra!");

        return sb.toString();
    }
    private void imprimirComprobante() {
        PrinterJob job = PrinterJob.getPrinterJob();
        job.setPrintable(this);
        boolean doPrint = job.printDialog();
        if (doPrint) {
            try {
                job.print();
            } catch (PrinterException e) {
                e.printStackTrace();
            }
        }
    }
    @Override
    public int print(Graphics g, PageFormat pf, int page) throws PrinterException {
        if (page > 0) {
            return NO_SUCH_PAGE;
        }
        Graphics2D g2d = (Graphics2D) g;
        g2d.translate(pf.getImageableX(), pf.getImageableY());
        comprobanteTextArea.printAll(g);
        return PAGE_EXISTS;
    }
}
