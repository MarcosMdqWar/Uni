package tp;

import java.util.Date;
/**
 * @author Marcos
 * 
 */
public class Orden {

    private int id;
    private Date fecha;
    private int id_prod;
    private int id_cli;
    private int cantidad;

    public Orden(int id, Date fecha, int id_prod, int id_cli, int cantidad) {
        this.id = id;
        this.fecha = fecha;
        this.id_prod = id_prod;
        this.id_cli = id_cli;
        this.cantidad = cantidad;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public Date getFecha() {
        return fecha;
    }

    public void setFecha(Date fecha) {
        this.fecha = fecha;
    }

    public int getId_prod() {
        return id_prod;
    }

    public void setId_prod(int id_prod) {
        this.id_prod = id_prod;
    }

    public int getId_cli() {
        return id_cli;
    }

    public void setId_cli(int id_cli) {
        this.id_cli = id_cli;
    }

    public int getCantidad() {
        return cantidad;
    }

    public void setCantidad(int cantidad) {
        this.cantidad = cantidad;
    }
}
