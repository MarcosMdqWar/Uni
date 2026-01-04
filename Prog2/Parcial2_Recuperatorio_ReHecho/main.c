/** RECU REHECHO
Desarrollar un programa en C para calcular el sueldo por horas trabajadas de los empleados contratados
por una empresa.
Los datos de los empleados van a estar almacenados en una cola. Cada nodo contendrá: DNI, apellido,
categoría, cantidad de horas trabajadas.
En una pila estarán almacenadas las categorías y el valor de hora.
Se pide:
1. Cargar pila y cola.
2. Almacenar en un árbol los datos de los empleados que hayan trabajado más de 10 horas. Cada nodo
del árbol contendrá DNI, Apellido, Sueldo. El árbol estará ordenado por DNI (tomar como nodo raíz el
 primer elemento de la cola con cantidad de horas mayor a 10).
3. Calcular porcentaje de empleados que trabajaron menos de 10 horas.
4. Mostrar el contenido del árbol ordenado.
*/
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include "RecuRH.h"

int main()
{
    RegPila *RegP = NULL;   //Pila
    RegCola *RegC = NULL;   //Cola
    CabCola *CabC = malloc(sizeof(CabCola));
    CabC->Pri = NULL; CabC->Ult = NULL;
    RegArbol *RegA = NULL;
    Apilar(&RegP,'C',852);
    Apilar(&RegP,'B',1100);
    Apilar(&RegP,'A',1500);
    LC *RegCirc = NULL;   //Circular
    LD *RegDoble = NULL;    //Doble
    CabezaD *CabD = malloc(sizeof(CabezaD)); CabD->Pri=NULL; CabD->Ult=NULL;
    //MostrarPila(RegP); TIRA ERROR
    int RES=7;
    do
    {
        printf("\n//Menu Recu//");
        printf("\n1: Cargar COLA ");
        printf("\n2: Mostrar COLA ");
        printf("\n3: Mostrar PILA ");
        printf("\n4: Cargar ARBOL ");
        printf("\n5: Mostrar ARBOL ");
        printf("\n6: Cargar LISTA CIRCULAR* ");
        printf("\n7: Mostrar LISTA CIRCULAR* ");
        printf("\n8: Cargar LISTA DOBLE** ");
        printf("\n9: Mostrar LISTA DOBLE** ");
        printf("\n0: Salir ");
        printf("\nIngrese opcion: ");
        scanf("%d",&RES);
        switch(RES) ///!NO OLVIDAR LOS break
        {
        case 1:{
            ///Encolar(&CabC); //Con datos
            Encolar2(&CabC,11369145,"PEREZ",'A',5); Encolar2(&CabC,12369145,"COLLA",'C',16);
            Encolar2(&CabC,13369145,"LUNA",'A',12); Encolar2(&CabC,14369145,"ANCAR",'B',9);
            Encolar2(&CabC,15369145,"NUNEZ",'B',5); Encolar2(&CabC,16369145,"SAB",'A',32);
            Encolar2(&CabC,17369145,"MARTEL",'C',15); Encolar2(&CabC,18369145,"TARCA",'A',2);
            printf("-Cargada Cola-\n"); break;}
        case 2:{
            printf("\nCola:"); MostrarCola(&CabC); //CabC, no RegC
            break;}
        case 3:{
            printf("\nPila:"); MostrarPila(RegP);
            break;}
        case 4:{
            printf("-Cargado ARbol-\n"); ArmarArbol(&RegA,&RegP,&CabC); ///Como luego se va a modificar RegA, va con & igual, y los otros voids con **
            break;}
        case 5:{
            printf("Arbol: "); Inorder(RegA);
            break;}
        case 6:{
            printf("Cargando circular-"); RecArbCargCirc(&RegCirc, RegA);
            break;}
        case 7:{
            printf("LC: "); MostrarCircular(RegCirc);
            break;}
        case 8:{
            printf("Cargando doble-"); RecCircCargaDoble(&CabD, RegCirc);
            break;}
        case 9:{
            printf("LD: "); MostrarDoble(CabD);
            break;}
        case 0:
            break;
        default:
            printf("\nIngrese numero 1-2");
        }
    }
    while(RES!=0);
    return 0;
}
