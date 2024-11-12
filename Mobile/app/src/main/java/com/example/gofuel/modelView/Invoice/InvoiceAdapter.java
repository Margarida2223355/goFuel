package com.example.gofuel.modelView.Invoice;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.databinding.ItemInvoiceBinding;
import com.example.gofuel.model.invoice.Invoice;

import java.util.ArrayList;

public class InvoiceAdapter extends BaseAdapter {
    private ArrayList<Invoice> invoices = new ArrayList<>();
    private final Context context;

    public InvoiceAdapter(Context context, ArrayList<Invoice> invoices) {
        this.context = context;
        this.invoices = invoices;
    }

    @Override
    public int getCount() {
        return invoices.size();
    }

    @Override
    public Object getItem(int i) {
        return invoices.get(i);
    }

    @Override
    public long getItemId(int i) {
        return invoices.get(i).getId();
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemInvoiceBinding binding;
        InvoiceItemViewModel viewModel;

        if (convertView == null) {
            binding = ItemInvoiceBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new InvoiceItemViewModel(binding);

            convertView.setTag(viewModel);
        }

        else {
            viewModel = (InvoiceItemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        viewModel.update(invoices.get(position));

        return convertView;
    }
}
