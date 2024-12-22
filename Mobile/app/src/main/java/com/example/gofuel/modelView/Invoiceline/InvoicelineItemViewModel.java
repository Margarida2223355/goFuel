package com.example.gofuel.modelView.Invoiceline;

import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;

public class InvoicelineItemViewModel {
    private final ItemItemsBinding binding;

    public InvoicelineItemViewModel(ItemItemsBinding binding) {
        this.binding = binding;
    }

    public ItemItemsBinding getItem() {
        return binding;
    }

    public void update(InvoiceLine item) {
        binding.itemName.setText(item.getItem().getDescription());
        binding.itemCategory.setText(item.getItem().getSubcategory().getCategory().getName());
        binding.itemTotal.setText(item.getTotal() + "€");
        binding.itemQty.setText(String.valueOf(item.getQty()));
    }
}
