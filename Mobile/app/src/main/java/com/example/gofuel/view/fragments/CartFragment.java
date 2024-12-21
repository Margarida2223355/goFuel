package com.example.gofuel.view.fragments;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

import com.example.gofuel.R;
import com.example.gofuel.databinding.FragmentCartBinding;
import com.example.gofuel.model.invoice.Invoice;

public class CartFragment extends Fragment {
    private FragmentCartBinding binding;
    private Invoice invoice;

    public CartFragment() {
        // Required empty public constructor
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        binding = FragmentCartBinding.inflate(inflater, container, false);
        View view = binding.getRoot();

        return view;
    }

    public void setInvoice(Invoice invoice) {
        this.invoice = invoice;
    }
}