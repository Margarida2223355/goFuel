package com.example.gofuel.modelView.Invoice;

import com.example.gofuel.databinding.ItemInvoiceBinding;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.util.Util;

public class InvoiceItemViewModel {
    private final ItemInvoiceBinding binding;

    public InvoiceItemViewModel(ItemInvoiceBinding binding) {
        this.binding = binding;
    }

    public ItemInvoiceBinding getItem() {
        return binding;
    }

    public void update(Invoice invoice) {
        binding.invoiceNumber.setText(String.valueOf(invoice.getId()));
        binding.invoiceStation.setText(invoice.getStation().getName());
        binding.invoiceDate.setText(Util.convertToData(invoice.getInvoice_date()));
    }
}
