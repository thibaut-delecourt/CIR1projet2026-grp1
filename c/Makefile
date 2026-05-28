# =====================================================================
#  Makefile - compile concepteur et solveur
# =====================================================================
#  Linux / WSL / MSYS2 :    make
#  Sortie : ./concepteur et ./solveur (ou .exe sous Windows)
# =====================================================================

CC      = gcc
CFLAGS  = -O2 -Wall -Wextra -std=c11
LDFLAGS =

ifeq ($(OS),Windows_NT)
    EXE = .exe
else
    EXE =
endif

CONCEPTEUR = concepteur$(EXE)
SOLVEUR    = solveur$(EXE)

COMMON_OBJ = fonctions.o

all: $(CONCEPTEUR) $(SOLVEUR)

$(CONCEPTEUR): concepteur.o $(COMMON_OBJ)
	$(CC) $(LDFLAGS) -o $@ $^

$(SOLVEUR): solveur.o $(COMMON_OBJ)
	$(CC) $(LDFLAGS) -o $@ $^

%.o: %.c jeu.h
	$(CC) $(CFLAGS) -c $< -o $@

clean:
	rm -f *.o $(CONCEPTEUR) $(SOLVEUR)

.PHONY: all clean
