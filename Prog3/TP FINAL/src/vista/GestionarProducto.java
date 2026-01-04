package vista;
/**
 * @author Marcos Joel Depaula
 * 
 */
import conexion.Conexion;
import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import javax.swing.table.DefaultTableModel;
import tp.Verificar;

public class GestionarProducto extends JFrame {

    private JTextField nombreField, precioField, stockField, id_provField;
    private JButton agregarButton, actualizarButton, eliminarButton, consultarButton;
    private JTable tabla;
    private DefaultTableModel modeloTabla;

    public GestionarProducto(Conexion conexion) {
        setTitle("Gestionar Productos");
        setSize(600, 400);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        setLayout(null);

        JLabel nombreLabel = new JLabel("Nombre:");
        nombreLabel.setBounds(10, 10, 100, 20);
        add(nombreLabel);

        nombreField = new JTextField();
        nombreField.setBounds(120, 10, 150, 25);
        add(nombreField);

        JLabel precioLabel = new JLabel("Precio:");
        precioLabel.setBounds(10, 40, 100, 20);
        add(precioLabel);

        precioField = new JTextField();
        precioField.setBounds(120, 40, 150, 25);
        add(precioField);

        JLabel stockLabel = new JLabel("Stock:");
        stockLabel.setBounds(10, 70, 100, 20);
        add(stockLabel);

        stockField = new JTextField();
        stockField.setBounds(120, 70, 150, 25);
        add(stockField);

        JLabel id_provLabel = new JLabel("ID Proveedor:");
        id_provLabel.setBounds(10, 100, 100, 20);
        add(id_provLabel);

        id_provField = new JTextField();
        id_provField.setBounds(120, 100, 150, 25);
        add(id_provField);

        agregarButton = new JButton("Agregar");
        agregarButton.setBounds(10, 150, 100, 30);
        add(agregarButton);

        actualizarButton = new JButton("Actualizar");
        actualizarButton.setBounds(120, 150, 100, 30);
        add(actualizarButton);

        eliminarButton = new JButton("Eliminar");
        eliminarButton.setBounds(230, 150, 100, 30);
        add(eliminarButton);

        consultarButton = new JButton("Consultar Todos");
        consultarButton.setBounds(10, 190, 150, 30);
        add(consultarButton);

        // Configurar JTable
        modeloTabla = new DefaultTableModel();
        tabla = new JTable(modeloTabla);
        JScrollPane scrollPane = new JScrollPane(tabla);
        scrollPane.setBounds(10, 240, 760, 120);
        add(scrollPane);

        agregarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String nombre = nombreField.getText();
                double precio = Double.parseDouble(precioField.getText());
                int stock = Integer.parseInt(stockField.getText());
                int id_prov = Integer.parseInt(id_provField.getText());
                String stock2 = stockField.getText();
                String id_prov2 = id_provField.getText();
                Verificar Verif = new Verificar(nombre, stock2, id_prov2);
                if (Verif.Ver(nombre, stock2, id_prov2) == 1) {
                    String sql = "INSERT INTO productos (nombre, precio, stock, id_prov) VALUES ('"
                            + nombre + "', " + precio + ", " + stock + ", " + id_prov + ")";
                    conexion.actualizar(sql);
                    JOptionPane.showMessageDialog(null, "Producto agregado exitosamente.");
                } else {
                    new Error().setVisible(true);
                }
            }
        });
        consultarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String sql = "SELECT nombre, precio, stock, id_prov FROM productos";
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
                String nombre = nombreField.getText();
                double precio = Double.parseDouble(precioField.getText());
                int stock = Integer.parseInt(stockField.getText());
                int id_prov = Integer.parseInt(id_provField.getText());

                String sql = "UPDATE productos SET precio = '" + precio + "', stock = '" + stock + "', id_prov = '" + id_prov
                        + "' WHERE nombre = '" + nombre + "'";
                conexion.actualizar(sql);
                JOptionPane.showMessageDialog(null, "Producto actualizado exitosamente.");
            }
        });
        eliminarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String nombre = nombreField.getText();
                String sql = "DELETE FROM productos WHERE nombre = '" + nombre + "'";
                conexion.actualizar(sql);
                JOptionPane.showMessageDialog(null, "Producto eliminado exitosamente.");
            }
        });
    }
}
