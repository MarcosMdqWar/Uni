package tp;
/**
 * @author Marcos
 * 
 */
public class Verificar {

    private String nombre;
    private String email;
    private String telefono;

    public Verificar(String nombre, String email, String telefono) {
        this.nombre = nombre;
        this.email = email;
        this.telefono = telefono;
    }

    public int Ver(String A, String B, String C) {
        if (A.length() > 0 && B.length() > 0 && C.length() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
