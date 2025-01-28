package com.example.gofuel.modelView.Station;

import android.view.View;

import androidx.appcompat.app.AppCompatActivity;

import com.example.gofuel.R;
import com.example.gofuel.databinding.ItemStationBinding;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.util.Util;
import com.example.gofuel.view.fragments.ItemFragment;

public class StationItemViewModel {
    private final ItemStationBinding binding;

    public StationItemViewModel(ItemStationBinding binding) {
        this.binding = binding;
    }

    public ItemStationBinding getItem() {
        return binding;
    }

    public void update(Station station) {
        binding.listItem.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                ItemFragment itemFragment = new ItemFragment();
                itemFragment.setStation(station);

                if (view.getContext() instanceof AppCompatActivity) {
                    AppCompatActivity activity = (AppCompatActivity) view.getContext();
                    activity.getSupportFragmentManager()
                            .beginTransaction()
                            .replace(R.id.fragment, itemFragment)
                            .addToBackStack(null)
                            .commit();
                }
            }
        });
        binding.itemName.setText(station.getName());
        binding.itemAddress.setText(station.getAddress());
        binding.itemPostal.setText(station.getPostal_code());
        binding.itemImage.setImageBitmap(Util.convertToImage(station.getImage()));
    }
}
