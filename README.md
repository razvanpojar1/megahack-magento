# Magento Warehouse Module 
 - challenge e-commerce MegaHeck Cluj-Napoca 11-13 November 2016
 - by MagentoCrew (Răzvan Pojar, Claudiu Mărgineanu, Marius Grad)

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
   ```modman clone https://github.com/razvanpojar1/megahack-magento.git```
 - Copy module archive  https://github.com/razvanpojar1/megahack-magento/archive/master.zip
 - Extract archive and place folder app from megahack-magento to magento root directory
 - Clear cache
 
# Module Usage
 - Login to Magento admin interface of the website
 - Check if module installed System->Configuration, left section Advanced->Advanced check if the module name "MagentoCrew_Warehouse" is enabled
 - Add new warehouse in admin Catalog->Manage Warehouse, click button "Add warehouse". There you add information about warehouse and products for that warehouse and the stock quantity for each selected products

# Module Future improvements
 - Email information about product and warehouse relation and show warehouse selected on shipment emails.
 - Stock rules for multiwarehouse on the same product
 - Product warehouse import CSV and SOAP
   
 - Multiselect on filters
 - Magento enterprise support
 
# Warnings
 - Diffecences from sum of qty on wrehouse level does not match the product stock level.
 **This is not a bug, it is an undocumanded feature**
 This is because, when you make an order the qty is reserved, substracted from product level stock qty. The warehouse stock level is updated/substracted when the shipment is made.   
 - When implementing import from csv make sure you support stock qty update on product as well. The qty difference from new/olv values should be added to the product stock qty.
 - The frontend theme module implemantations is based on rwd theme and base theme. In case of custom themes, you need to have a look if the block name "catalog.leftnav" and "catalogsearch.leftnav" is used in custom theme implementations. Those names are replaced with "catalog.leftnav.extend" and "catalogsearch.leftnav.extend"
 - It will not work with custom modules on layer navigations
 - It will not work with custom modules on admin shipment page
 
 
# Uninstall
 - disable module from etc/modules/MagentoCrew_Warehouse.xml
 - Delete the following files:
```
 app/code/community/MagentoCrew/*
 app/design/frontend/base/default/layout/magentocrew/*   
 app/design/frontend/base/default/template/magentocrew/* 
 app/design/adminhtml/default/default/layout/magentocrew/warehouse.xml
 app/design/adminhtml/default/default/layout/magentocrew/warehouse.xml
 app/design/adminhtml/default/default/template/magentocrew/warehouse*    
 app/locale/ro_RO/MagentoCrew_Warehouse.csv                                     
 app/locale/en_US/MagentoCrew_Warehouse.csv                                         
 app/etc/modules/MagentoCrew_Warehouse.xml
 ```
 - Remove custom theme implemenations from theme if it's the case
 - Drop the following tables from SQL
```
warehouse
warehouse_product
```  
 - Remove column `warehouse_id` from table `sales_flat_order_shipment`
