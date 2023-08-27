class Invoice:
    def __init__(self, invoice_id, customer_id, address, last_name, first_name, phone_number, items_with_price=None):
        self.invoice_id = invoice_id
        self.customer_id = customer_id
        self.last_name = last_name
        self.first_name = first_name
        self.phone_number = phone_number
        self.address = address
        if items_with_price is None:
            self.items_with_price = {}

    def __str__(self):
        return self.invoice_id + ": " + self.customer_id + ": " + self.last_name + ", " + self.first_name + " Phone: " \
            + self.phone_number + " Address: " + self.address

    def __repr__(self):
        return 'Customer({},{},{},{},{})'.format(self.invoice_id, self.customer_id, self.last_name, self.first_name,
                                                 self.phone_number, self.address)

    def add_item(self, item):
        self.items_with_price.update(item)

    def create_invoice(self):
        total = 0
        for item, price in self.items_with_price.items():
            print(f"{item}.....${price:.2f}")
            total += price
        tax = total * 0.06
        print(f"Tax..... ${tax:.2f}")
        total_with_tax = tax + total
        print(f"Total.....${total_with_tax:.2f}")


if __name__ == '__main__':
    invoice = Invoice(1, 123, '1313 Disneyland Dr, Anaheim, CA 92802', 'Mouse', 'Minnie', '555-867-5309')
    invoice.add_item({'iPad': 799.99})
    invoice.add_item({'Surface': 999.99})
    invoice.create_invoice()
