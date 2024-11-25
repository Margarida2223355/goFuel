package com.example.gofuel.modelView.Main;

import com.example.gofuel.databinding.ItemPendingBinding;
import com.example.gofuel.databinding.ItemStationBinding;
import com.example.gofuel.model.invoice.pending.PendingInvoice;
import com.example.gofuel.model.station.Station;

public class PendingItemViewModel {
    private final ItemPendingBinding binding;

    public PendingItemViewModel(ItemPendingBinding binding) {
        this.binding = binding;
    }

    public ItemPendingBinding getItem() {
        return binding;
    }

    public void update(String name, String value) {
        binding.name.setText(name);
        binding.value.setText(value + "€");
    }
}
