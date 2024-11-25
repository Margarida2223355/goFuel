package com.example.gofuel.modelView.Main;

import com.example.gofuel.databinding.FavoriteStationBinding;
import com.example.gofuel.model.client_station.ClientStation;

public class ClientStationItemViewModel {
    private final FavoriteStationBinding binding;

    public ClientStationItemViewModel(FavoriteStationBinding binding) {
        this.binding = binding;
    }

    public FavoriteStationBinding getItem() {
        return binding;
    }

    public void update(ClientStation station) {
        binding.stationName.setText(station.getStation().getName());
    }
}
