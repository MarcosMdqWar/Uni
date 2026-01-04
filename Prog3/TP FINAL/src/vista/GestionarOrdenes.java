package vista;
/**
 * @author Marcos Joel Depaula
 * 
 */
import conexion.Conexion;
import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.Date;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import javax.swing.table.DefaultTableModel;
import tp.Verificar;

public class GestionarOrdenes extends JFrame {

    private JTextField fechaField, idProdField, idCliField, cantidadField;
    private JButton agregarButton, actualizarButton, eliminarButton, consultarButton;
    private JTable tabla;
    private DefaultTableModel modeloTabla;

    public GestionarOrdenes(Conexion conexion) {
        setTitle("Gestionar Órdenes");
        setSize(600, 400);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        setLayout(null);

        JLabel fechaLabel = new JLabel("Fecha (YYYY-MM-DD):");
        fechaLabel.setBounds(10, 10, 150, 20);
        add(fechaLabel);

        fechaField = new JTextField();
        fechaField.setBounds(170, 10, 150, 25);
        add(fechaField);

        JLabel idProdLabel = new JLabel("ID Producto:");
        idProdLabel.setBounds(10, 40, 100, 20);
        add(idProdLabel);

        idProdField = new JTextField();
        idProdField.setBounds(170, 40, 150, 25);
        add(idProdField);

        JLabel idCliLabel = new JLabel("ID Cliente:");
        idCliLabel.setBounds(10, 70, 100, 20);
        add(idCliLabel);

        idCliField = new JTextField();
        idCliField.setBounds(170, 70, 150, 25);
        add(idCliField);

        JLabel cantidadLabel = new JLabel("Cantidad:");
        cantidadLabel.setBounds(10, 100, 100, 20);
        add(cantidadLabel);

        cantidadField = new JTextField();
        cantidadField.setBounds(170, 100, 150, 25);
        add(cantidadField);

        agregarButton = new JButton("Agregar");
        agregarButton.setBounds(10, 150, 100, 30);
        add(agregarButton);

        actualizarButton = new JButton("Actualizar");
        actualizarButton.setBounds(120, 150, 100, 30);
        add(actualizarButton);

        eliminarButton = new JButton("Eliminar");
        eliminarButton.setBounds(230, 150, 100, 30);
        add(eliminarButton);

        consultarButton = new JButton("Consultar Todas");
        consultarButton.setBounds(10, 190, 150, 30);
        add(consultarButton);

        modeloTabla = new DefaultTableModel();
        tabla = new JTable(modeloTabla);
        JScrollPane scrollPane = new JScrollPane(tabla);
        scrollPane.setBounds(10, 240, 760, 120);
        add(scrollPane);

        agregarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String id_prod2 = idProdField.getText();
                String id_cli2 = idCliField.getText();
                String cantidad2 = cantidadField.getText();
                Verificar Verif = new tp.Verificar(id_prod2, id_cli2, cantidad2);
                if (Verif.Ver(id_prod2, id_cli2, cantidad2) == 1) {
                    Date fecha = Date.valueOf(fechaField.getText());
                    int id_prod = Integer.parseInt(idProdField.getText());
                    int id_cli = Integer.parseInt(idCliField.getText());
                    int cantidad = Integer.parseInt(cantidadField.getText());
                    double precio = obtenerPrecioProducto(conexion, id_prod);
                    double total = cantidad * precio;
                    String sql = "INSERT INTO ordenes (fecha, id_prod, id_cli, cantidad) VALUES ('"
                            + fecha + "', " + id_prod + ", " + id_cli + ", " + cantidad + ")";
                    conexion.actualizar(sql);
                    JOptionPane.showMessageDialog(null, "Orden agregada exitosamente.");
                    // Crear y mostrar el comprobante de pago [!]
                    Comprobante comprobante = new Comprobante(fecha.toString(), id_prod, id_cli, cantidad, total);
                    comprobante.setVisible(true);
                } else {
                    new vista.Error().setVisible(true);
                }
            }
        });
        eliminarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                int id_cli = Integer.parseInt(idCliField.getText());
                String sql = "DELETE FROM ordenes WHERE id_cli = '" + id_cli + "'";
                conexion.actualizar(sql);
                JOptionPane.showMessageDialog(null, "Orden eliminada exitosamente.");
            }
        });
        consultarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String sql = "SELECT * FROM ordenes";
                ResultSet rs = conexion.consultar(sql);
                try {
                    ResultSetMetaData metaData = rs.getMetaData();
                    int columnCount = metaData.getColumnCount();
                    modeloTabla.setRowCount(0);
                    modeloTabla.setColumnCount(0);
                    for (int i = 1; i <= columnCount; i++) {
                        modeloTabla.addColumn(metaData.getColumnName(i));
                    }
                    while (rs.next()) {
                        Object[] row = new Object[columnCount];
                        for (int i = 1; i <= columnCount; i++) {
                            row[i - 1] = rs.getObject(i);
                        }
                        modeloTabla.addRow(row);
                    }
                } catch (SQLException ex) {
                    ex.printStackTrace();
                }
            }
        });
        actualizarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                Date fecha = Date.valueOf(fechaField.getText());
                int id_prod = Integer.parseInt(idProdField.getText());
                int id_cli = Integer.parseInt(idCliField.getText());
                int cantidad = Integer.parseInt(cantidadField.getText());

                String sql = "UPDATE ordenes SET fecha = '" + fecha + "', id_prod = '" + id_prod + "', cantidad = '" + cantidad
                        + "' WHERE id_cli = '" + id_cli + "'";
                conexion.actualizar(sql);
                JOptionPane.showMessageDialog(null, "Orden actualizado exitosamente.");
            }
        });
    }

    private double obtenerPrecioProducto(Conexion conexion, int id_prod) {
        double precio = 0.0;
        String sql = "SELECT precio FROM productos WHERE id = " + id_prod;
        ResultSet rs = conexion.consultar(sql);
        if (rs == null) {
            System.err.println("Error.");
            return precio;
        }
        try {
            if (rs.next()) {
                precio = rs.getDouble("precio");
            }
        } catch (SQLException ex) {
            ex.printStackTrace();
        }
        return precio;
    }
}
