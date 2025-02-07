package com.example.gofuel.modelView.Invoiceline;

import android.view.View;

import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.util.Util;

public class InvoicelineItemViewModel {
    private final ItemItemsBinding binding;

    public InvoicelineItemViewModel(ItemItemsBinding binding) {
        this.binding = binding;
    }

    public ItemItemsBinding getItem() {
        return binding;
    }

    public void update(InvoiceLine item) {
        binding.checkBox.setVisibility(View.VISIBLE);
        binding.itemUnitPrice.setVisibility(View.GONE);

        binding.itemName.setText(item.getItem().getDescription());
        binding.itemCategory.setText(item.getItem().getSubcategory().getCategory().getName());
        binding.itemImage.setImageBitmap(Util.convertToImage(item.getItem().getImage()));

        if ((item.getItem().getSubcategory().getCategory().getName().equals("Gasoline") || (item.getItem().getSubcategory().getCategory().getName().equals("Diesel")))) {
            binding.itemTotal.setText(String.format("%.2f", item.getQty()) + " UN");
            binding.itemQty.setText(String.format("%.2f", item.getTotal()) + "€");
        } else {
            binding.itemTotal.setText(String.format("%.2f", item.getTotal()) + "€");
            binding.itemQty.setText(String.format("%.2f", item.getQty()));
        }
    }
}