#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#define MAX 20
typedef struct nodoPila
{
    char Categ;
    float Valor;
    struct nodoPila *Abajo;
} RegPila;
typedef struct nodoCola
{
    int DNI;
    char Ap[MAX];
    char Categ;
    int Cant;
    struct nodoCola *Sig;
} RegCola;
typedef struct Cabeza
{
    RegCola *Pri;
    RegCola *Ult;
} CabCola;
typedef struct nodoArbol
{
    int DNI;
    char Ap[MAX];
    float Sueldo;
    struct nodoArbol *Izq;
    struct nodoArbol *Der;
} RegArbol;
typedef struct VecArb
{
    int DNI;
    char Ap[MAX];
    char Categ;
    int Cant;
} VecArb;
typedef struct Pila
{
    char Categ;
    float Valor;
} VecPila;
typedef struct SubL
{
    float Sueldo;
    struct SubL *Sig;
} LSub;
typedef struct nodoCirc
{
    int DNI;
    char Ap[MAX];
    struct nodoCirc *Sig;
    LSub *Sub;
} LC;
typedef struct nodoDoble
{
    char Ap[MAX];
    struct nodoDoble *Pre;
    struct nodoDoble *Sig;
} LD;
typedef struct
{
    LD *Pri;
    LD *Ult;
} CabezaD;
//COLA
RegCola *gnodoCola()
{
    RegCola *NC = malloc(sizeof(RegCola));
    int DNI; char Ap[MAX]; char Categ; int Cant;
    do
    {
        printf("\nIngrese DNI: ");    ///FALTAN DO WHILES
        scanf("%d",&DNI);
    }
    while(DNI<10000000);
    printf("\nIngrese Apellido: "); fflush(stdin); gets(Ap); strcpy(Ap,toupper(Ap));
    printf("\nIngrese Categoria: "); scanf("%c",&Categ); Categ = toupper(Categ);
    do
    {
        printf("\nIngrese Cantidad de horas: "); scanf("%d",&Cant);
    }
    while (Cant<0);
    NC->DNI = DNI;strcpy(NC->Ap, Ap);NC->Categ=Categ;NC->Cant = Cant;NC->Sig = NULL;
    return NC;
}
void Encolar(CabCola **CabC)
{
    RegCola *AuxC = gnodoCola();
    if ((*CabC)->Pri == NULL)
        (*CabC)->Pri = AuxC;
    else
    {
        (*CabC)->Ult->Sig = AuxC;
    }
    (*CabC)->Ult = AuxC;
}
void Encolar2(CabCola **CabC,int DNI,char Ap[],int Categ, int Cant)
{
    RegCola *AuxC = malloc(sizeof(RegCola));
    AuxC->Sig = NULL;
    AuxC->DNI = DNI;
    strcpy(AuxC->Ap,Ap);
    AuxC->Categ=Categ;
    AuxC->Cant=Cant;
    if ((*CabC)->Pri == NULL)
        (*CabC)->Pri = AuxC;
    else
    {
        (*CabC)->Ult->Sig = AuxC;
    }
    (*CabC)->Ult = AuxC;
}
void Desencolar(CabCola **CabC,int *DNI, char Ap[],char *Categ, int *Cant)
{
    RegCola *Q;
    Q = ((*CabC)->Pri);
    if ( (*CabC)->Pri != NULL)
    {
        *DNI = Q->DNI;
        *Cant = Q->Cant;
        *Categ = Q->Categ;
        strcpy(Ap,Q->Ap);
        if ((*CabC)->Pri != (*CabC)->Ult)
        {
            (*CabC)->Pri = (*CabC)->Pri->Sig;
        }
        else
        {
            (*CabC)->Pri = NULL;
            (*CabC)->Ult = NULL;
        }
        free(Q);
    }
}
void MostrarCola(CabCola **CabC)
{
    int DNI;
    char Ap[MAX];
    char Categ;
    int Cant;
    if ( ((*CabC)->Pri) != NULL)
    {
        Desencolar(&(*CabC),&DNI,Ap,&Categ,&Cant);
        printf("\n%d %s %c %d",DNI, Ap, Categ, Cant);
        MostrarCola(&(*CabC));
        Encolar2(&(*CabC),DNI,Ap,Categ,Cant);
    }
    else
        printf(".\n");
}
//PILA
void Apilar(RegPila **RegP,int Categ,float Valor)
{
    RegPila *AuxP = malloc(sizeof(RegPila));
    AuxP->Categ = Categ;
    AuxP->Valor = Valor;
    AuxP->Abajo = (*RegP);
    (*RegP) = AuxP;
}
void Desapilar(RegPila **RegP,char *Categ, float *Valor)
{
    RegPila *Q = (*RegP);
    if ((*RegP)!=NULL)
    {
        *Categ = Q->Categ;
        *Valor = Q->Valor;
        (*RegP) = (*RegP)->Abajo;
        free(Q);
    }
}
void MostrarPila(RegPila *RegP)
{
    char Categ;
    float Valor;
    if (RegP != NULL)
    {
        Desapilar(&RegP,&Categ,&Valor);
        printf("[%c|$%.2f] ",Categ, Valor);
        MostrarPila(RegP);
        Apilar(&RegP,Categ,Valor);
    }
}
//ARBOL
void CargarArbol(RegArbol **RegA,int DNI, char Ap[], float Sueldo)
{
    if (*RegA == NULL)
    {
        (*RegA) = malloc(sizeof(RegArbol));    //!!!!
        (*RegA)->Izq=NULL;
        (*RegA)->Der=NULL;
        (*RegA)->DNI = DNI;
        strcpy((*RegA)->Ap,Ap);
        (*RegA)->Sueldo = Sueldo;
    }
    else if ((*RegA)->DNI > DNI)
        CargarArbol(&(*RegA)->Izq,DNI,Ap,Sueldo);
    else
        CargarArbol(&(*RegA)->Der,DNI,Ap,Sueldo);
}
void BuscaCola(RegArbol **RegA, CabCola **CabC,VecPila VP[], int *a, int *acum, int i)
{
    int DNI; char Ap[MAX]; char Categ; int Cant; float Sueldo;
    if ( ((*CabC)->Pri) != NULL)
    {
        Desencolar(&(*CabC),&DNI,Ap,&Categ,&Cant);
        //
        (*acum)=(*acum)+1;
        if(Cant>10)
        {
            int s=0;
            for(s=0; s<i; s++)
            {
                if (VP[s].Categ == Categ)
                {
                    Sueldo = (Cant)*(VP[s].Valor);
                }
            }
            CargarArbol(RegA,DNI,Ap,Sueldo);
        }
        else
            (*a)=(*a)+1;
        //
        BuscaCola(RegA,CabC,VP,&(*a),&(*acum),i);   //! LOS &* &*
        Encolar2(&(*CabC),DNI,Ap,Categ,Cant);
    }
}
void ArmarArbol(RegArbol **RegA,RegPila **RegP, CabCola **CabC)
{
    VecPila VP[MAX];
    int i=0;
    CargarVector(VP,&(*RegP),&i);   ///&*!
    int a=0;
    int acum=0;
    BuscaCola(RegA, CabC,VP,&a,&acum,i);
    printf("%d %d",a,acum);
    float sol = ((a*100)/acum);
    printf("\nEl porcentaje de los que trabajaron MENOS de 10hs es: %c%.0f ",37,sol);
}
int CargarVector(VecPila VP[],RegPila **RegP, int *i)
{
    char Categ;
    float Valor;
    if (*RegP != NULL)  ///&*!
    {
        Desapilar(RegP,&Categ,&Valor);
        VP[*i].Categ = Categ;
        VP[*i].Valor = Valor;
        (*i)=(*i)+1;
        CargarVector(VP,&(*RegP),i);    ///&*!
        Apilar(RegP,Categ,Valor);
    }
}
void Inorder(RegArbol *RegA)
{
    if (RegA != NULL)
    {
        Inorder(RegA->Izq);
        printf("(%d - %s - $%.2f)\n",RegA->DNI,RegA->Ap,RegA->Sueldo);
        Inorder(RegA->Der);
    }
}
//LISTA CIRCULAR
void InsertarCirc(LC **RegCirc,int DNI, char Ap[], float Sueldo)
{
    LC *Nuevo = malloc(sizeof(LC));
    strcpy(Nuevo->Ap,Ap); Nuevo->DNI = DNI;
    Nuevo->Sub = malloc(sizeof(LSub)); Nuevo->Sub->Sueldo = Sueldo;
    if ((*RegCirc) == NULL)
    {
        Nuevo->Sig = Nuevo;
        (*RegCirc) = Nuevo; //_!
    }
    else
    {
        LC *Act = (*RegCirc);   //PUNTEROS
        while (Act->Sig != (*RegCirc))
            Act = Act->Sig;
        Act->Sig = Nuevo;
        Nuevo->Sig = (*RegCirc);
    }
}
void RecArbCargCirc(LC **RegCirc, RegArbol *RegA)
{
    if (RegA != NULL)
    {
        RecArbCargCirc(RegCirc,RegA->Izq);
        InsertarCirc(RegCirc,RegA->DNI,RegA->Ap,RegA->Sueldo);
        RecArbCargCirc(RegCirc,RegA->Der);
    }
}
void MostrarCircular(LC *RegCirc)
{
    if (RegCirc==NULL)
        printf("Vacio");
    else
    {
        LC *Act = RegCirc;   //PUNTEROS
        do
        {
            printf("[%d, %s]",Act->DNI,Act->Ap);
            if (Act->Sub != NULL)
            {
                printf("-Sub->(%.2f) ",Act->Sub->Sueldo);
            }
            Act = Act->Sig;
        }
        while (Act != RegCirc);
    }
}
//LISTA DOBLE
void CargaDoble(CabezaD **CabD, char Ap[])
{
    LD *ND = malloc(sizeof(LD));
    strcpy(ND->Ap,Ap);
    if ((*CabD)->Pri == NULL)
    {
        (*CabD)->Pri = ND; (*CabD)->Ult = ND;
        ND->Pre = NULL; ND->Sig = NULL;
    }
    else    //Inserta ordenado
    {
        LD *ActD = ((*CabD)->Pri);
        while( ((ActD->Sig)!=NULL) && (strcmp(ActD->Ap,Ap)<0) )
        {
            ActD = ActD->Sig;
        }
        if (ActD->Sig==NULL)
        {
            ActD->Sig = ND;
            (*CabD)->Ult = ND; ND->Pre = ActD; ND->Sig = NULL;
        }
        else
        {
            ND->Sig = ActD->Sig;
            ActD->Sig = ND;
            ND->Pre = ActD;
        }
    }
}
void RecCircCargaDoble(CabezaD **CabD, LC *RegCirc)
{
    if (RegCirc != NULL)
    {
        LC *ActC = RegCirc;
        while(ActC->Sig != RegCirc){
            CargaDoble(&(*CabD),ActC->Ap);
            ActC = ActC->Sig;}
    }
    else
    {
        printf("Circular vacia");
    }
}
void MostrarDoble(CabezaD *CabD)
{
    LD *Act = CabD->Pri;
    while (Act != NULL)
    {
        printf("'%s' ",Act->Ap);
        Act = Act->Sig;
    }
}

////////////////////////////////////////////////////////////////////////////////////////////////////
/*void Encolar(CabCola **CabC)
{
    RegCola *N = gnodo();
    if ((*CabC)->Pri == NULL)
    {
        (*CabC)->Pri = N;
        (*CabC)->Ult = N;
    }
    else
    {
        (*CabC)->Ult->Sig = N;
        (*CabC)->Ult = N;
    }
}
void Desencolar(CabCola **CabC, int *dato)
{
    RegCola *Q = (*CabC)->Pri;
    if ((*CabC)->Pri != NULL)   //!
    {
        *dato = Q->dato;
        if ((*CabC)->Pri == (*CabC)->Ult)
        {
            (*CabC)->Pri = NULL;
            (*CabC)->Ult = NULL;
        }
        else
        {
            (*CabC)->Pri = (*CabC)->Pri->Sig;
        }
        free(Q);
    }
}
void Apilar(RegPila **RegP)
{
    RegPila *NP = gnodop();
    NP->Abajo = (*RegP);
    (*RegP) = NP;
}
void Desapilar(RegPila **RegP, int *dato)
{
    RegPila *Q = (*RegP);
    if ((*RegP)!=NULL)
    {
        *dato = Q->dato;
        (*RegP) = (*RegP)->Abajo;
    }
    free(Q);
}
void AAB(RegArbol **RegA,int *dato)
{
    if ((*RegA)==NULL)
    {
        (*RegA) = malloc(sizeof(RegArbol)); //!
        (*RegA)->Izq = NULL; (*RegA)->Der = NULL;
        (*RegA)->dato = *dato;
    }
    else
    {
        if ((*RegA)->dato > *dato)
            ABB(&(*RegA)->Izq,&(*dato));
        else
            ABB(&(*RegA)->der,&(*dato));
    }
}
*/
