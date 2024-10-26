package com.example.gofuel.view.Fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;
import androidx.lifecycle.ViewModelProvider;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ProgressBar;

import com.example.gofuel.databinding.FragmentStationListBinding;
import com.example.gofuel.model.station.Station;
import com.example.gofuel.modelView.Station.StationAdapter;
import com.example.gofuel.modelView.Station.StationViewModel;

import java.util.ArrayList;

public class StationFragment extends Fragment {

    private FragmentStationListBinding binding;
    private ArrayList<Station> stations;

    public StationFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentStationListBinding.inflate(inflater, container,false);
        View view = binding.getRoot();

        stations = new ArrayList<>();
        addStations();
        binding.stationList.setAdapter(new StationAdapter(getContext(), stations));

        return view;
    }

    public void addStations() {
        stations.add(new Station(1, "Name1", "Address1", "Cod1"));
        stations.add(new Station(2, "Name2", "Address2", "Cod2"));
        stations.add(new Station(3, "Name3", "Address3", "Cod3"));
    }
}