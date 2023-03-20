<script>
    function calculePrice(product_id, pc_numbers) {
        let product = products.filter(p => p.id == product_id)[0];
        pc_numbers = Number(pc_numbers);
        if (pc_numbers == 0 || pc_numbers < product.min_pc_number) {
            return 0.0;
        }

        let price = product.price;

        // calculer le prix
        let additional_pc = pc_numbers - product.min_pc_number;

        if (additional_pc > 0) {
            price += additional_pc * product.price_per_additional_pc;
        }

        return price;
    }
</script>
