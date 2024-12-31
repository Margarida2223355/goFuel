package com.example.gofuel.modelView.Invoice;

import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.example.gofuel.R;
import com.example.gofuel.databinding.ItemInvoiceBinding;
import com.example.gofuel.model.invoice.Invoice;
import com.example.gofuel.util.Util;
import com.example.gofuel.view.fragments.CartFragment;

public class InvoiceItemViewModel {
    private final ItemInvoiceBinding binding;

    public InvoiceItemViewModel(ItemInvoiceBinding binding) {
        this.binding = binding;
    }

    public ItemInvoiceBinding getItem() {
        return binding;
    }

    public void update(Invoice invoice) {
        binding.listItem.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                CartFragment cartFragment = new CartFragment();
                cartFragment.setInvoice(invoice);

                if (view.getContext() instanceof AppCompatActivity) {
                    AppCompatActivity activity = (AppCompatActivity) view.getContext();
                    activity.getSupportFragmentManager()
                            .beginTransaction()
                            .replace(R.id.fragment, cartFragment)
                            .addToBackStack(null)
                            .commit();
                }
            }
        });

        binding.invoiceNumber.setText(String.valueOf(invoice.getCode()));
        binding.invoiceStation.setText(invoice.getStation().getName());
        binding.invoiceDate.setText(Util.convertToData(invoice.getInvoice_date()));
    }
}
