IE4727 Case Study 05 - JavaJam Coffee House

SETUP (Windows / XAMPP)
1. Start Apache and MySQL in XAMPP.
2. Copy the IE4727-CS5-completed folder into C:\xampp\htdocs\
3. Open http://localhost:8000/phpmyadmin/ (or use port 80 if Apache is configured for 80).
4. Import pricechange/coffeedb.sql in phpMyAdmin. This creates the "price" database,
   the product prices table, and orders/order_items tables.
5. Visit http://localhost:8000/IE4727-CS5-completed/menu.php
6. ADMIN: http://localhost:8000/IE4727-CS5-completed/menuadmin.php
7. REPORT: http://localhost:8000/IE4727-CS5-completed/salesreport.php

PART (i) PRICE UPDATE
- Check one or more products, enter new prices, click Update Prices.
- PHP validates positive monetary prices (max 2 decimal places).
- PHP updates MySQL coffeprice using prepared statements in a transaction.
- Current updated prices are queried and shown again on the same admin page.
- The customer menu uses live prices from the same database.

PART (ii) CHECKOUT & SALES REPORT
- Enter quantities, choose a shot for each ordered Cafe au Lait or Cappuccino.
- JS computes subtotals/total as the user changes selections.
- Check-Out posts quantities and options to checkout.php.
- PHP validates input, fetches CURRENT prices from DB, calculates totals server-side,
  and saves to orders + order_items in a database transaction.
- Receipt confirms the order and amounts saved.
- The sales report supports a date picker, revenue & units by product/category,
  and the most popular shot of the best-selling product.

IMPORTANT
- This is a teaching/demo project. The admin page has no login/authentication;
  do not expose it to the public internet as a real store.
- MySQL default root password assumed blank (XAMPP localhost only). If different,
  edit pricechange/db.php.
- MySQL/PHP runtime cannot be fully tested without your running XAMPP environment.
