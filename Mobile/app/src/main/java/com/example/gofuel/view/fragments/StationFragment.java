package com.example.gofuel.view.fragments;

import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import com.example.gofuel.databinding.FragmentStationBinding;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.modelView.Station.StationAdapter;
import com.example.gofuel.modelView.Station.StationViewModel;
import com.example.gofuel.util.State;

import java.util.ArrayList;

public class StationFragment extends Fragment {

    private FragmentStationBinding binding;
    private StationViewModel viewModel;

    public StationFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentStationBinding.inflate(inflater, container,false);
        View view = binding.getRoot();

        viewModel = new ViewModelProvider(this).get(StationViewModel.class);

        viewModel.getState().observe(getViewLifecycleOwner(), state -> {
            if (state instanceof State.Loading) {
                binding.stationList.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.loading.setVisibility(View.VISIBLE);
            }
            else if (state instanceof State.StationList) {
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.GONE);
                binding.stationList.setVisibility(View.VISIBLE);
                ArrayList<Station> stations = new ArrayList<>(((State.StationList) state).getStations());
                binding.stationList.setAdapter(new StationAdapter(getContext(), stations));
            }
            else if (state instanceof State.EmptyState) {
                binding.stationList.setVisibility(View.GONE);
                binding.loading.setVisibility(View.GONE);
                binding.emptyState.setVisibility(View.VISIBLE);
            }
        });

        viewModel.loadStations();

        return view;
    }
}