# Magento Warehouse Module 
 - challenge e-commerce MegaHeck Cluj-Napoca 11-13 November 2016
 - by MagentoCrew (Razvan Pojar, Claudiu Margineanu, Marius Grad)

Problem scope:
Background: datorită sistemului de licitații publice, ANAF nu poate decide fără licitații un curier anume care să facă expedițiile, deci pentru început produsele se vor rezerva și ridica din depozit.
Challenge: trebuie realizat un modul de Magento (1.9.2.4 sau 1.9.3.1 dacă se lansează până atunci), care să facă următoarele:
tracking de stoc multi-warehouse la nivel de produs
afișare în pagina de produs a depozitelor în care produsul respectiv este disponibil
filtrare în pagina de categorie doar după produse disponibile într-o anumită locație
afișare în checkout la livrare a metodei “Ridicare din depozit” cu menționarea depozitului (sau depozitelor) în care sunt produsele
(bonus) afișare în mail-ul de confirmare a comenzii a depozitului pentru fiecare produs
(bonus) forțare la nivel de Ship pe order la alegerea doar a produselor dintr-un anume depozit (astfel, personalul va face o fișă de “expediție” pentru produsele din depozitul Galați și o va trimite prin mail acestora pentru a pregăti produsele)
Modulul trebuie să fie realizat cu modman și să includă un fișier readme.md. Orice resurse (blocuri statice, atribute etc.) pe care le necesită modulul trebuiesc create prin script-urile de sql/install din modul. Modulul trebuie să includă traduceri de ro_RO și en_US.
