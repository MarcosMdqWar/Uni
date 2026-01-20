package vista;
/**
 * @author Marcos
 * 
 */
import conexion.Conexion;
import java.awt.Color;
import javax.swing.*;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import javax.swing.table.DefaultTableModel;
import tp.Verificar;

public class GestionarProveedores extends JFrame {

    private JTextField nombreField, direccionField, telefonoField;
    private JButton agregarButton, actualizarButton, eliminarButton, consultarButton;
    private JTable tabla;
    private DefaultTableModel modeloTabla;

    public GestionarProveedores(Conexion conexion) {
        setTitle("Gestionar Proveedores");
        setSize(600, 400);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        setLayout(null);

        JLabel nombreLabel = new JLabel("Nombre:");
        nombreLabel.setBounds(10, 10, 100, 20);
        add(nombreLabel);

        nombreField = new JTextField();
        nombreField.setBounds(120, 10, 150, 25);
        add(nombreField);

        JLabel direccionLabel = new JLabel("Dirección:");
        direccionLabel.setBounds(10, 40, 100, 20);
        add(direccionLabel);

        direccionField = new JTextField();
        direccionField.setBounds(120, 40, 150, 25);
        add(direccionField);

        JLabel telefonoLabel = new JLabel("Teléfono:");
        telefonoLabel.setBounds(10, 70, 100, 20);
        add(telefonoLabel);

        telefonoField = new JTextField();
        telefonoField.setBounds(120, 70, 150, 25);
        add(telefonoField);

        agregarButton = new JButton("Agregar");
        agregarButton.setBounds(10, 150, 100, 30);
        add(agregarButton);

        actualizarButton = new JButton("Actualizar");
        actualizarButton.setBounds(120, 150, 100, 30);
        add(actualizarButton);

        eliminarButton = new JButton("Eliminar por Nombre");
        eliminarButton.setBounds(230, 150, 150, 30);
        add(eliminarButton);

        consultarButton = new JButton("Consultar todo");
        consultarButton.setBounds(10, 190, 150, 30);
        add(consultarButton);

        // Configurar JTable
        modeloTabla = new DefaultTableModel();
        tabla = new JTable(modeloTabla);
        JScrollPane scrollPane = new JScrollPane(tabla);
        scrollPane.setBounds(10, 230, 560, 120);
        add(scrollPane);

        agregarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String nombre = nombreField.getText();
                String direccion = direccionField.getText();
                String telefono = telefonoField.getText();
                Verificar Verif = new Verificar(nombre, direccion, telefono);
                if (Verif.Ver(nombre, direccion, telefono) == 1) {
                    String sql = "INSERT INTO proveedores (nombre, direccion, telefono) VALUES ('"
                            + nombre + "', '" + direccion + "', '" + telefono + "')";
                    conexion.actualizar(sql);
                    JOptionPane.showMessageDialog(null, "Proveedor agregado exitosamente.");
                } else {
                    new Error().setVisible(true);
                }
            }
        });
        eliminarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String nombre = nombreField.getText();
                String sql = "DELETE FROM proveedores WHERE nombre = '" + nombre + "'";
                conexion.actualizar(sql);
                JOptionPane.showMessageDialog(null, "Proveedor eliminado exitosamente.");
            }
        });
        consultarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String nombre = nombreField.getText();
                String sql = "SELECT * FROM proveedores";
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
                String dir = direccionField.getText();
                String telefono = telefonoField.getText();

                String sql = "UPDATE proveedores SET direccion = '" + dir + "', telefono = '" + telefono
                        + "' WHERE nombre = '" + nombre + "'";
                conexion.actualizar(sql);
                JOptionPane.showMessageDialog(null, "Proveedor actualizado exitosamente.");
            }
        });
    }
}
