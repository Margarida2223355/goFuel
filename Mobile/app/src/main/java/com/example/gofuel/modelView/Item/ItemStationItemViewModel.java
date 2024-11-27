package com.example.gofuel.modelView.Item;

import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.example.gofuel.R;
import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.databinding.ItemStationBinding;
import com.example.gofuel.model.item.Item;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station.StationItem;
import com.example.gofuel.view.fragments.ItemFragment;

public class ItemStationItemViewModel {
    private final ItemItemsBinding binding;

    public ItemStationItemViewModel(ItemItemsBinding binding) {
        this.binding = binding;
        binding.itemQty.setText("1");
    }

    public ItemItemsBinding getItem() {
        return binding;
    }

    public void update(StationItem item) {
        binding.itemName.setText(item.getItem().getDescription());
        binding.itemCategory.setText(item.getItem().getSubcategory().getCategory().getName());
        binding.itemUnitPrice.setText(item.getPrice() + "€");

        Double finalValue = (Integer.parseInt(binding.itemQty.getText().toString())) * (item.getPrice());
        binding.itemTotal.setText(finalValue + "€");
    }
}
