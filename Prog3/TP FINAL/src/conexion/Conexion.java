package conexion;
/**
 * @author Marcos Joel Depaula
 * 
 */
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Statement;

public class Conexion {

    private String servidor = "localhost";
    private String database = "tpfinalmarcos";
    private String usuario = "root";
    private String password = "";
    private String url = "";
    private Statement stm;
    private ResultSet rs;
    private Connection connection;

    public Conexion(String url, String database, String usuario, String password) {
        connect();
    }

    private void connect() {
        try {
            Class.forName("com.mysql.cj.jdbc.Driver");
            url = "jdbc:mysql://" + servidor + ":3306/" + database;
            connection = DriverManager.getConnection(url, usuario, password);
            System.out.println("Conexion a Base de Datos " + url + " . . . . .Ok");
        } catch (SQLException | ClassNotFoundException ex) {
            System.out.println(ex);
        }
    }

    public Connection getConnection() {
        return connection;
    }

    public ResultSet consultar(String sql) {
        try {
            Statement statement = connection.createStatement();
            return statement.executeQuery(sql);
        } catch (SQLException e) {
            e.printStackTrace();
            return null;
        }
    }

    public void actualizar(String sql) {
        try {
            Statement statement = connection.createStatement();
            statement.executeUpdate(sql);
        } catch (SQLException e) {
            e.printStackTrace();
        }
    }
}