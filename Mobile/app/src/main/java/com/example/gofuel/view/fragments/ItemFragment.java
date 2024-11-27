package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.gofuel.R;
import com.example.gofuel.databinding.FragmentItemBinding;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.model.station.StationItem;
import com.example.gofuel.modelView.Item.ItemAdapter;
import com.example.gofuel.modelView.Item.ItemViewModel;
import com.example.gofuel.util.State;

import java.util.ArrayList;

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
                binding.itemList.setAdapter(new ItemAdapter(getContext(), stationItems));
            }

            else if (state instanceof State.EmptyState){
                binding.itemList.setVisibility(View.GONE);
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.VISIBLE);
            }
        });

        viewModel.loadItems();

        return view;
    }

    public void setStation(Station station) {
        this.station = station;
    }
}