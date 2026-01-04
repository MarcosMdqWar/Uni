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
import java.util.*;
import tp.Verificar;

public class GestionarClientes extends JFrame {

    private JTextField nombreField, emailField, telefonoField;
    private JButton agregarButton, actualizarButton, eliminarButton, consultarButton;
    private JTable tabla;
    private DefaultTableModel modeloTabla;

    public GestionarClientes(Conexion conexion) {
        setTitle("Gestionar Clientes");
        setSize(600, 400);
        setDefaultCloseOperation(JFrame.DISPOSE_ON_CLOSE);
        setLayout(null);

        JLabel nombreLabel = new JLabel("Nombre:");
        nombreLabel.setBounds(10, 10, 100, 20);
        add(nombreLabel);

        nombreField = new JTextField();
        nombreField.setBounds(120, 10, 150, 25);
        add(nombreField);

        JLabel emailLabel = new JLabel("Email:");
        emailLabel.setBounds(10, 40, 100, 20);
        add(emailLabel);

        emailField = new JTextField();
        emailField.setBounds(120, 40, 150, 25);
        add(emailField);

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

        consultarButton = new JButton("Consultar Todo");
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
                String email = emailField.getText();
                String telefono = telefonoField.getText();
                //Set<String> set1 = new LinkedHashSet<String>();
                //set1.add(nombre); set1.add(email); set1.add(telefono);
                Verificar Verif = new Verificar(nombre, email, telefono);
                if (Verif.Ver(nombre, email, telefono) == 1) {
                    String sql = "INSERT INTO clientes (nombre, email, telefono) VALUES ('"
                            + nombre + "', '" + email + "', '" + telefono + "')";
                    conexion.actualizar(sql);
                    JOptionPane.showMessageDialog(null, "Cliente agregado exitosamente.");
                } else {
                    new Error().setVisible(true);
                }

            }
        });

        eliminarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String nombre = nombreField.getText();
                String sql = "DELETE FROM clientes WHERE nombre = '" + nombre + "'";
                conexion.actualizar(sql);
                JOptionPane.showMessageDialog(null, "Cliente eliminado exitosamente.");
            }
        });

        consultarButton.addActionListener(new ActionListener() {
            @Override
            public void actionPerformed(ActionEvent e) {
                String sql = "SELECT * FROM clientes";
                ResultSet rs = conexion.consultar(sql);
                try {
                    ResultSetMetaData metaData = rs.getMetaData();
                    int columnCount = metaData.getColumnCount(); //Limpiar la tabla
                    modeloTabla.setRowCount(0);
                    modeloTabla.setColumnCount(0);
                    for (int i = 1; i <= columnCount; i++) { //Agregar nombres de columnas
                        modeloTabla.addColumn(metaData.getColumnName(i));
                    }
                    while (rs.next()) { //Agregar filas
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
                String email = emailField.getText();
                String telefono = telefonoField.getText();
                Verificar Verif = new Verificar(nombre, email, telefono);
                if (Verif.Ver(nombre, email, telefono) == 1) {
                    String sql = "UPDATE clientes SET email = '" + email + "', telefono = '" + telefono
                            + "' WHERE nombre = '" + nombre + "'";
                    conexion.actualizar(sql);
                    JOptionPane.showMessageDialog(null, "Cliente actualizado exitosamente.");
                } else {
                    new Error().setVisible(true);
                }

            }
        });
    }
}
