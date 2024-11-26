package com.example.gofuel.modelView.Main;

import com.example.gofuel.databinding.ItemFinishedBinding;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.util.Util;

public class FinishedtemViewModel {
    private final ItemFinishedBinding binding;

    public FinishedtemViewModel(ItemFinishedBinding binding) {
        this.binding = binding;
    }

    public ItemFinishedBinding getItem() {
        return binding;
    }

    public void update(FinishedInvoice invoice) {
        binding.invoiceDate.setText(Util.convertToData(invoice.getInvoice_date()));
        binding.invoiceValue.setText(invoice.getTotal() + "€");
    }
}
