package com.example.gofuel.modelView.Station;

import com.example.gofuel.databinding.ItemStationBinding;
import com.example.gofuel.model.station.Station;

public class StationItemViewModel {
    private final ItemStationBinding binding;

    public StationItemViewModel(ItemStationBinding binding) {
        this.binding = binding;
    }

    public ItemStationBinding getItem() {
        return binding;
    }

    public void update(Station station) {
        binding.itemName.setText(station.getName());
        binding.itemAddress.setText(station.getAddress());
        binding.itemPostal.setText(station.getPostal_code());
    }
}
