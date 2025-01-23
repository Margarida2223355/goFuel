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
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.util.callback.OnCheckedBox;
import com.example.gofuel.util.callback.OnItemQtyChange;

import java.util.ArrayList;

public class InvoicelineAdapter extends BaseAdapter {
    private ArrayList<InvoiceLine> invoiceLines = new ArrayList<>();
    private final Context context;
    private final OnCheckedBox onCheckedBox;
    private final OnItemQtyChange onItemQtyChange;

    public InvoicelineAdapter(Context context, ArrayList<InvoiceLine> invoiceLines, OnCheckedBox onCheckedBox, OnItemQtyChange onItemQtyChange) {
        this.context = context;
        this.invoiceLines = invoiceLines;
        this.onCheckedBox = onCheckedBox;
        this.onItemQtyChange = onItemQtyChange;
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

        InvoiceLine currentItem = invoiceLines.get(position);

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

        viewModel.update(currentItem);

        binding.checkBox.setOnCheckedChangeListener(new CompoundButton.OnCheckedChangeListener() {
            @Override
            public void onCheckedChanged(CompoundButton compoundButton, boolean b) {
                if (b) { onCheckedBox.onChecked(currentItem); }
                else { onCheckedBox.onUnchecked(currentItem); }
            }
        });

        binding.addBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                currentItem.addQty();
                onItemQtyChange.onUpdateQty(currentItem);
            }
        });

        binding.removeBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                currentItem.removeQty();
                onItemQtyChange.onUpdateQty(currentItem);
            }
        });

        return convertView;
    }
}
