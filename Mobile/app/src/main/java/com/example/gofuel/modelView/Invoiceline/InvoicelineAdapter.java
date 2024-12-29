package com.example.gofuel.modelView.Invoiceline;

import android.content.Context;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.CompoundButton;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.MyApplication;
import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.model.invoice.invoiceline.InvoiceLine;
import com.example.gofuel.util.callback.OnCheckedBox;

import java.util.ArrayList;

public class InvoicelineAdapter extends BaseAdapter {
    private ArrayList<InvoiceLine> invoiceLines = new ArrayList<>();
    private final Context context;
    private final OnCheckedBox onCheckedBox;

    public InvoicelineAdapter(Context context, ArrayList<InvoiceLine> invoiceLines, OnCheckedBox onCheckedBox) {
        this.context = context;
        this.invoiceLines = invoiceLines;
        this.onCheckedBox = onCheckedBox;
    }

    @Override
    public int getCount() {
        return invoiceLines.size();
    }

    @Override
    public Object getItem(int i) {
        return invoiceLines.get(i);
    }

    @Override
    public long getItemId(int i) {
        return invoiceLines.get(i).getId();
    }

    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemItemsBinding binding;
        InvoicelineItemViewModel viewModel;

        if (convertView == null) {
            binding = ItemItemsBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new InvoicelineItemViewModel(binding);

            convertView.setTag(viewModel);
        }
        else {
            viewModel = (InvoicelineItemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        binding.checkBox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                if (b) { onCheckedBox.onChecked(invoiceLines.get(position)); }
                else { onCheckedBox.onUnchecked(invoiceLines.get(position)); }
            }
        });

        viewModel.update(invoiceLines.get(position));

        return convertView;
    }
}
