package com.example.gofuel.view.fragments;

import android.os.Bundle;
import android.text.Editable;
import android.text.TextWatcher;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Toast;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.example.gofuel.databinding.FragmentItemBinding;
import com.example.gofuel.databinding.ItemItemsBinding;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station_item.StationItem;
import com.example.gofuel.modelView.Item.ItemAdapter;
import com.example.gofuel.modelView.Item.ItemStationItemViewModel;
import com.example.gofuel.modelView.Item.ItemViewModel;
import com.example.gofuel.util.State;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

public class ItemFragment extends Fragment {
    private FragmentItemBinding binding;
    private Station station;
    private ItemViewModel viewModel;

    public ItemFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentItemBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(ItemViewModel.class);

        viewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.Loading) {
                binding.itemList.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.loading.setVisibility(View.VISIBLE);
            }

            else if (state instanceof State.StationItemList) {
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.itemList.setVisibility(View.VISIBLE);
                ArrayList<StationItem> stationItems = new ArrayList<>(((State.StationItemList) state).getStationItems());
                binding.itemList.setAdapter(new ItemAdapter(getContext(), stationItems, (show) -> {
                    if (show) { binding.cardButton.setVisibility(View.VISIBLE); }
                    else { binding.cardButton.setVisibility(View.GONE); }
                }));

                //Disable list clicks
                binding.itemList.setEnabled(false);
            }

            else if (state instanceof State.EmptyState){
                binding.itemList.setVisibility(View.GONE);
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.VISIBLE);
            }
        });

        viewModel.loadItems(station);

        //region On card button click
        binding.cardButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                HashMap<StationItem, Integer> cardItems = new HashMap<>();

                for (int i=0; i<binding.itemList.getCount(); i++) {
                    ItemStationItemViewModel itemViewModel = (ItemStationItemViewModel) binding.itemList.getChildAt(i).getTag();
                    cardItems.put(itemViewModel.getStationItem(), Integer.valueOf(itemViewModel.getItem().itemQty.getText().toString()));
                }

                /* TESTE - Margarida
                for (Map.Entry<StationItem, Integer> entry : cardItems.entrySet()) {
                    Log.i("-->", "StationItem: " + entry.getKey().getItem().getDescription() + " -- Quantity: " + entry.getValue());
                }*/
            }
        });
        //endregion

        //region Search for Category/Description
        binding.searchText.addTextChangedListener(new TextWatcher() {
            @Override
            public void beforeTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void onTextChanged(CharSequence charSequence, int i, int i1, int i2) {

            }

            @Override
            public void afterTextChanged(Editable editable) {
                viewModel.getItemsByCategoryDescription(editable.toString());
            }
        });
        //endregion

        //region Clear search text
        binding.clearIcon.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                binding.searchText.clearFocus();
                binding.searchText.setText("");
            }
        });
        //endregion

        return view;
    }

    public void setStation(Station station) {
        this.station = station;
    }
}