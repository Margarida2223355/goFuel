package com.example.gofuel.modelView.Station;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.databinding.ItemStationBinding;
import com.example.gofuel.model.station.Station;

import java.util.ArrayList;

public class StationAdapter extends BaseAdapter {
    private ArrayList<Station> stations = new ArrayList<>();
    private final Context context;

    public StationAdapter(Context context, ArrayList<Station> stations) {
        this.context = context;
        this.stations = stations;
    }

    @Override
    public int getCount() {
        return stations.size();
    }

    @Override
    public Object getItem(int i) {
        return stations.get(i);
    }

    @Override
    public long getItemId(int i) {
        return stations.get(i).getId();
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        ItemStationBinding binding;
        StationItemViewModel viewModel;

        if (convertView == null) {
            binding = ItemStationBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new StationItemViewModel(binding);

            convertView.setTag(viewModel);
        } else {
            viewModel = (StationItemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        viewModel.update(stations.get(position));

        return convertView;
    }
}
