<h2>Pre-requisites:</h2>
    WordPress<br>
    WooCommerce<br>
    Some test products (can be default WooCommerce test data)<br>

<h2>Tasks:</h2>
    For each product add a new tab named “Information for goners”. The content of the tab should be editable on the product edit page. Do not use any 3rd-party plugins for the purpose of this task.
    Add a new text input field on the product page (the view page, NOT the edit page). You can decide your own name and label for this field. The user will use this field to enter a custom quote (propose his own price) for the product. So, if a user puts some number on this field, adds the product to the cart, proceeds through checkout, and makes an order – the value of this field should be displayed next to this particular product in this particular order details at the [WooCommerce > Orders] page in the dashboard. Do not use any 3rd-party plugins for the purpose of this task.
    Select some 4 random products in your test data. 
    When the order is created (after checkout is complete), and if it contains ANY of these 4 products, do the following:
    Remove those products from this current order.
    Create one more order programmatically and fill in the data from the original order (shipping address, payment option, user, etc). Switch the status of this additional order to “On Hold”. Add products removed from the original order to this additional order.

<h2>Deliverable (either of those):</h2>
    A test website with implemented tasks<br>
    A plugin that implements these tasks<br>
