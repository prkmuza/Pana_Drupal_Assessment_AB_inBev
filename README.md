Installation
=================================

1. Requires PHP 8.1.25. Running Drupal 10.0.0
2. Please run/import the sql file "drupaldb.sql" to install database. It can be found in project root
3. Test CSV file "ProductImports.csv" that can be uploaded to system. It can be found in project root

How it works
=================================

1. Import CSV home page can be found here http://localhost/Pana_Drupal_Assessment_AB_inBev/import-csv
2. Attach a CSV file
3. System will prompt you to generate a draft so you see the results before import
4. After importing, file is posted to the server, file is then read, and then its contents are sorted in a manner which can be saved to Drupal DB
5. Please reach out if you need further explanation