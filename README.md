# Magento Warehouse Module 
 - challenge e-commerce MegaHeck Cluj-Napoca 11-13 November 2016
 - by MagentoCrew (Razvan Pojar, Claudiu Margineanu, Marius Grad)

Problem scope(Romanian Description):

Background: 
 - datorită sistemului de licitații publice, ANAF nu poate decide fără licitații un curier anume care să facă expedițiile, deci pentru început produsele se vor rezerva și ridica din depozit.
Challenge: 
 - trebuie realizat un modul de Magento (1.9.2.4 sau 1.9.3.1 dacă se lansează până atunci), care să facă următoarele:
tracking de stoc multi-warehouse la nivel de produs
 - afișare în pagina de produs a depozitelor în care produsul respectiv este disponibil
 - filtrare în pagina de categorie doar după produse disponibile într-o anumită locație
 - afișare în checkout la livrare a metodei “Ridicare din depozit” cu menționarea depozitului (sau depozitelor) în care sunt produsele
 - (bonus) afișare în mail-ul de confirmare a comenzii a depozitului pentru fiecare produs
 - (bonus) forțare la nivel de Ship pe order la alegerea doar a produselor dintr-un anume depozit (astfel, personalul va face o fișă de “expediție” pentru produsele din depozitul Galați și o va trimite prin mail acestora pentru a pregăti produsele)
 
Modulul trebuie să fie realizat cu modman și să includă un fișier readme.md. Orice resurse (blocuri statice, atribute etc.) pe care le necesită modulul trebuiesc create prin script-urile de sql/install din modul. Modulul trebuie să includă traduceri de ro_RO și en_US.

Problem scope(English Description):
Background:
 - Thanks to public tenders, auctions ANAF can not decide without a specific courier to make shipments, so initially it will book and pick up products from the warehouse.
Challenge:
 - develope a Magento module (1.9.2.4 or 1.9.3.1 if it launches before) to do the following:
multi-warehouse inventory tracking at the product level
 - Display product page warehouses where the product is available
 - Filtration category page just after the products available in a particular location
 - Display in checkout delivery method "Lifting the deposit" mentioning the deposit (or deposits) are products
 - (Bonus) display in mail order confirmation deposit for each product
 - (Bonus) forcing at the Ship in order to just choosing products from a particular warehouse (thus, the staff will make a record of "expedition" for goods in warehouse Galati and send by mail them to prepare products)
 
The module must be done with modman and include a file readme.md. Any resources (static blocks, attributes, etc.) that you require module must be created through SQL scripts / install mode. The module should include translations ro_RO and en_US.

# Install Module
 - Install module using modman:
   modman clone https://github.com/razvanpojar1/megahack-magento.git
 - Copy module archive  https://github.com/razvanpojar1/megahack-magento/archive/master.zip
 - extract archive and place folder app from megahack-magento to magento root directory
 - clear cache
 
# Module Usage
 - Login to Magento admin interface of the website
 - check if module installed System->Configuration, left section Advanced->Advanced check if the module name "MagentoCrew_Warehouse" is enabled
 - add new warehouse in admin Catalog->Manage Warehouse, click button "Add warehouse". There you add information about warehouse and products for that warehouse and the stock quantity for each selected products

# Module Future improvements
 - email information about product and warehouse relation
 - stock rules for multiwarehouse on the same product
 
