package com.example.gofuel.modelView.Main.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.databinding.FavoriteStationBinding;
import com.example.gofuel.databinding.ItemFinishedBinding;
import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.model.invoice.finished.FinishedInvoice;
import com.example.gofuel.modelView.Main.ClientStationItemViewModel;
import com.example.gofuel.modelView.Main.FinishedtemViewModel;

import java.util.ArrayList;

public class FinishedInvoiceAdapter extends BaseAdapter {
    private ArrayList<FinishedInvoice> finishedInvoices = new ArrayList<>();
    private final Context context;

    public FinishedInvoiceAdapter(Context context, ArrayList<FinishedInvoice> finishedInvoices) {
        this.context = context;
        this.finishedInvoices = finishedInvoices;
    }

    @Override
    public int getCount() {
        return finishedInvoices.size();
    }

    @Override
    public Object getItem(int i) {
        return finishedInvoices.get(i);
    }

    @Override
    public long getItemId(int i) {
        return finishedInvoices.get(i).getId();
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemFinishedBinding binding;
        FinishedtemViewModel viewModel;

        if (convertView == null) {
            binding = ItemFinishedBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new FinishedtemViewModel(binding);

            convertView.setTag(viewModel);
        } else {
            viewModel = (FinishedtemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        viewModel.update(finishedInvoices.get(position));

        return convertView;
    }
}
