package com.example.gofuel.modelView.Main.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;

import com.example.gofuel.databinding.FavoriteStationBinding;
import com.example.gofuel.model.client_station.ClientStation;
import com.example.gofuel.modelView.Main.ClientStationItemViewModel;

import java.util.ArrayList;

public class ClientStationAdapter extends BaseAdapter {
    private ArrayList<ClientStation> favoriteStation = new ArrayList<>();
    private final Context context;

    public ClientStationAdapter(Context context, ArrayList<ClientStation> favoriteStation) {
        this.context = context;
        this.favoriteStation = favoriteStation;
    }

    @Override
    public int getCount() {
        return favoriteStation.size();
    }

    @Override
    public Object getItem(int i) {
        return favoriteStation.get(i);
    }

    @Override
    public long getItemId(int i) {
        return favoriteStation.get(i).getClient().getId();
    }

    @NonNull
    @Override
    public View getView(int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        FavoriteStationBinding binding;
        ClientStationItemViewModel viewModel;

        if (convertView == null) {
            binding = FavoriteStationBinding.inflate((LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE));
            convertView = binding.getRoot();
            viewModel = new ClientStationItemViewModel(binding);

            convertView.setTag(viewModel);
        } else {
            viewModel = (ClientStationItemViewModel) convertView.getTag();
            binding = viewModel.getItem();
        }

        viewModel.update(favoriteStation.get(position));

        return convertView;
    }
}
