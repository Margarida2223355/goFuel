package com.example.gofuel.modelView.Item;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.databinding.ItemStationBinding;
import com.example.gofuel.model.station.StationItem;
import com.example.gofuel.modelView.Station.StationItemViewModel;

import java.util.ArrayList;

public class ItemAdapter extends BaseAdapter {
    private ArrayList<StationItem> stationItems;
    private final Context context;

    public ItemAdapter(Context context, ArrayList<StationItem> stationItems) {
        this.context = context;
        this.stationItems = stationItems;
    }

    @Override
    public int getCount() {
        return stationItems.size();
    }

    @Override
    public Object getItem(int i) {
        return stationItems.get(i);
    }

    @Override
    public long getItemId(int i) {
        return stationItems.get(i).getId();
    }

    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemItemsBinding binding;
        ItemStationItemViewModel viewModel;

        if (convertView == null) {
            binding = ItemItemsBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new ItemStationItemViewModel(binding);

            convertView.setTag(viewModel);
        } else {
            viewModel = (ItemStationItemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        viewModel.update(stationItems.get(position));

        return convertView;
    }
}
