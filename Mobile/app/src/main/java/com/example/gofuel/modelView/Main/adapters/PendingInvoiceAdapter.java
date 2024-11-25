package com.example.gofuel.modelView.Main.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.databinding.FavoriteStationBinding;
import com.example.gofuel.databinding.ItemPendingBinding;
import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.modelView.Main.ClientStationItemViewModel;
import com.example.gofuel.modelView.Main.PendingItemViewModel;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

public class PendingInvoiceAdapter extends BaseAdapter {
    private final HashMap<String, String> pendingValues;
    private final Context context;
    private final List<String> keys;

    public PendingInvoiceAdapter(Context context, HashMap<String, String> pendingValues) {
        this.context = context;
        this.pendingValues = pendingValues;
        this.keys = new ArrayList<>(pendingValues.keySet());
    }

    @Override
    public int getCount() {
        return pendingValues.size();
    }

    @Override
    public Object getItem(int i) {
        return pendingValues.get(keys.get(i));
    }

    @Override
    public long getItemId(int i) {
        return i;
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemPendingBinding binding;
        PendingItemViewModel viewModel;

        if (convertView == null) {
            binding = ItemPendingBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new PendingItemViewModel(binding);

            convertView.setTag(viewModel);
        } else {
            viewModel = (PendingItemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        viewModel.update(keys.get(position), pendingValues.get(keys.get(position)));

        return convertView;
    }
}
