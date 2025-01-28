package com.example.gofuel.modelView.Item;

import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.util.Util;

public class ItemStationItemViewModel {
    private final ItemItemsBinding binding;
    private StationItem stationItem;

    public ItemStationItemViewModel(ItemItemsBinding binding) {
        this.binding = binding;
        //binding.itemQty.setText("0"); //If we need to set default value
    }

    public ItemItemsBinding getItem() {
        return binding;
    }

    public StationItem getStationItem() {
        return stationItem;
    }

    public void update(StationItem item, int qty) {
        this.stationItem = item;
        binding.itemName.setText(item.getItem().getDescription());
        binding.itemCategory.setText(item.getItem().getSubcategory().getCategory().getName());
        binding.itemUnitPrice.setText(String.format("%.2f", item.getPrice()) + "€");
        binding.itemQty.setText(String.valueOf(qty));
        binding.itemImage.setImageBitmap(Util.convertToImage(item.getItem().getImage()));

        Double finalValue = qty * (item.getPrice());
        binding.itemTotal.setText(String.format("%.2f", finalValue) + "€");
    }
}
