#!/usr/bin/python
# -*- coding: utf-8 -*-
# Encoding: UTF-8

# Copyright (C) 2016 Caleb Reister

# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.

# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.

# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.

# Script to determine the best series or parallel resistor combination to obtain
# a given value using standard resistor values.
# argv[1]: desired resistance
# argv[2]: tolerance (10%, 5%, or 1%)

# import pdb
import sys
from math import *
from array import *


def findIndex(l, value):
    # Finds index in list l that is closest to value.
    # Uses a binary search.
    low = 0
    high = len(l) - 1
    while low + 1 < high:
        mid = (low + high) // 2  # // is integer division
        if l[mid] > value:
            high = mid
        elif l[mid] < value:
            low = mid
        else:
            return mid
    if abs(l[high] - value) < abs(l[low] - value):
        return high
    else:
        return low


def toSI(d, unit, digits=2):
    # Pretty print for SI numbers
    # d: number the print
    # unit: SI unit to use
    # digits: level of precision (number of decimal digits)
    incPrefixes = ["k", "M", "G", "T", "P", "E", "Z", "Y"]
    decPrefixes = ["m", "µ", "n", "p", "f", "a", "z", "y"]
    if d != 0:
        degree = int(floor(log10(abs(d)) / 3))
    else:
        degree = 0
    prefix = ""
    if degree != 0:
        if degree > 0:
            if degree - 1 < len(incPrefixes):
                prefix = incPrefixes[degree - 1]
            else:
                prefix = incPrefixes[-1]
                degree = len(incPrefixes)
        elif degree < 0:
            if -degree - 1 < len(decPrefixes):
                prefix = decPrefixes[-degree - 1]
            else:
                prefix = decPrefixes[-1]
                degree = -len(decPrefixes)
        scaled = float(d * pow(1000, -degree))
        s = "{scaled:3.{dig}f}{prefix}{unit}".format(
            scaled=scaled, prefix=prefix, dig=digits, unit=unit
        )
    else:
        s = "{d:>3.{dig}f}{unit}".format(d=d, dig=digits, unit=unit)
    return s


def main(resistance, tolerance):
    # Desired resistance
    try:
        rd = float(resistance)
    except IndexError:
        print("Syntax: resistor.py R [tolerance]")
        quit()

    tol = 0

    # Set default tolerance to 5%
    try:
        tolerance = str(tolerance)
    except IndexError:
        sys.argv.append("5%")
        print("No tolerance provided. Assuming 5%.")

    if tolerance == "10%" or tolerance == "10":
        rbase = [1, 1.2, 1.5, 1.8, 2.2, 2.7, 3.3, 3.9, 4.7, 5.6, 6.8, 8.2]
        tol = 0.10
    elif tolerance == "5%" or tolerance == "5":
        rbase = [
            1,
            1.1,
            1.2,
            1.3,
            1.5,
            1.6,
            1.8,
            2.0,
            2.2,
            2.4,
            2.7,
            3.0,
            3.3,
            3.6,
            3.9,
            4.3,
            4.7,
            5.1,
            5.6,
            6.2,
            6.8,
            7.5,
            8.2,
            9.1,
        ]
        tol = 0.05
    elif tolerance == "1%" or tolerance == "1":
        rbase = [
            1.00,
            1.02,
            1.05,
            1.07,
            1.10,
            1.13,
            1.15,
            1.18,
            1.21,
            1.24,
            1.27,
            1.30,
            1.33,
            1.37,
            1.40,
            1.43,
            1.47,
            1.50,
            1.54,
            1.58,
            1.62,
            1.65,
            1.69,
            1.74,
            1.78,
            1.82,
            1.87,
            1.91,
            1.96,
            2.00,
            2.05,
            2.10,
            2.15,
            2.21,
            2.26,
            2.32,
            2.37,
            2.43,
            2.49,
            2.55,
            2.61,
            2.67,
            2.74,
            2.80,
            2.87,
            2.94,
            3.01,
            3.09,
            3.16,
            3.24,
            3.32,
            3.40,
            3.48,
            3.57,
            3.65,
            3.74,
            3.83,
            3.92,
            4.02,
            4.12,
            4.22,
            4.32,
            4.42,
            4.53,
            4.64,
            4.75,
            4.87,
            4.99,
            5.11,
            5.23,
            5.36,
            5.49,
            5.62,
            5.76,
            5.90,
            6.04,
            6.19,
            6.34,
            6.49,
            6.65,
            6.81,
            6.98,
            7.15,
            7.32,
            7.50,
            7.68,
            7.87,
            8.06,
            8.25,
            8.45,
            8.66,
            8.87,
            9.09,
            9.31,
            9.53,
            9.76,
        ]
        tol = 0.01
    else:
        raise ValueError("Please choose between 10%, 5%, or 1% tolerance.")

    R = array("f")  # Resistance
    G = array("f")  # Conductance

    # Generate resistance array, sorted low to high
    for b in range(0, 7):
        for a in rbase:
            R.append(a * 10 ** b)

    # Generate conductance array, sorted low to high
    for r in R:
        G.insert(0, 1 / r)

    # Setup to compute series combinations
    # Start with r1 being the closest value in R to rd
    # and r2 being 0.
    r1i = findIndex(R, rd)
    rr = R[r1i]  # Result of operation (r1+r2 or r1||r2)
    err = (rr - rd) / rd  # Error of rres relative to rd
    out = []
    if abs(err) <= tol:
        out.append([R[r1i], " +", 0, rr, err])

    # Compute possible series combinations: r1i is decremented by 1
    # each iteration and used to find r2i. NOTE: this does NOT give
    # every possible combination within tolerance of rd. It chooses
    # the optimum value of r2i for a given r1i using findIndex. This
    # is most likely more efficient than testing for every value
    # within tolerance.
    while R[r1i] >= rd / 2 or r1i == 0:
        r1i = r1i - 1
        r2d = rd - R[r1i]
        r2i = findIndex(R, r2d)
        rr = R[r1i]
        err = rr / rd - 1
        # Append result to output if it is within tolerance. This will
        # be true in most cases.
        if abs(err) <= tol:
            out.append([R[r1i], " +", R[r2i], rr, err])

    # Setup for parallel combinations
    gd = 1 / rd
    g1i = findIndex(G, gd)

    # Compute parallel combinations
    # Again, this does not find every possible combination, only the
    # best value given the other resistor.
    while G[g1i] >= (gd) / 2:
        g2d = gd - G[g1i]
        g2i = findIndex(G, g2d)
        gr = G[g1i] + G[g2i]
        err = gd / gr - 1.0
        if abs(err) <= tol:
            out.append([1 / G[g1i], "||", 1 / G[g2i], 1 / gr, err])
        g1i = g1i - 1

    # Sort and print result
    out.sort(key=lambda i: abs(i[4]))  # Sort from lowest to highest error
    print("\nDesired Resistance: ", toSI(rd, " ohm", 5))
    for i in out:
        print(
            (
                "{:>10}".format(toSI(i[0], " ohm")),
                " ",
                i[1],
                "{:>10}".format(toSI(i[2], " ohm")),
                "  =  ",
                "{:10}".format(toSI(i[3], " ohm")),
                "  ",
                "({:+3.3%})".format(i[4]),
            )
        )


if __name__ == "__main__":
    resistance = sys.argv[1]
    tolerance = sys.argv[2]
    main(resistance, tolerance)
