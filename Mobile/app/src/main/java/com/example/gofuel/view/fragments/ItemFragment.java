package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.gofuel.R;
import com.example.gofuel.databinding.FragmentItemBinding;
import com.example.gofuel.model.station.Station;

public class ItemFragment extends Fragment {
    private FragmentItemBinding binding;
    private Station station;

    public ItemFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentItemBinding.inflate(inflater, container, false);
        View view = binding.getRoot();
        
        return view;
    }

    public void setStation(Station station) {
        this.station = station;
    }
}