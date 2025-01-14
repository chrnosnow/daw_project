<?php
require_once __DIR__ . '/../module/fpdf/fpdf.php';

class UserFeeListPDF extends FPDF
{
    protected $FONT_SIZE_SMALL = 10;
    protected $FONT_SIZE_NORMAL = 12;
    protected $FONT_SIZE_LARGE = 20;
    protected $DARK_BLUE = [26, 46, 73];
    protected $WHITE = [255, 255, 255];
    protected $LIGHT_YELLOW = [255, 252, 230];
    // page header
    function Header()
    {
        // background color
        $this->SetFillColor($this->LIGHT_YELLOW[0], $this->LIGHT_YELLOW[1], $this->LIGHT_YELLOW[2]);
        $this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F');

        //add new font
        $this->AddFont('AvenisRegular', '', 'Avenis.php');
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');

        // logo and library info (top left)
        $this->Image('../resurse/imagini/logo_mba_fara_scris.jpg', 10, 10, 20, 0, '', '../index.php');
        $this->SetTextColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]);
        $this->SetXY(10, 32);
        $this->SetFont('AvenisSemibold', '', $this->FONT_SIZE_SMALL);
        $this->MultiCell(0, 5, "Biblioteca MICA BUFNITA A ATENEI\nBulevardul Colinelor Intortocheate, nr. 7\nIasi, Romania", 0, 'L');
    }

    //set user information on top right
    function UserInfo(array $user)
    {
        $this->SetFont('AvenisRegular', '', $this->FONT_SIZE_SMALL);
        // $this->SetXY(120, 40);
        $this->SetTextColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]);
        $labelWidth = 20;
        $valueWidth = 40;
        $details = [
            'Utilizator' => $user['username'],
            'Email' => $user['email'],
            'Nr. permis' => $user['card_no']
        ];

        $startX = 130;
        $startY = 40;
        $lineHeight = 6;

        foreach ($details as $label => $value) {
            $this->SetXY($startX, $startY);
            $this->Cell($labelWidth, $lineHeight, $label . ':', 0, 0, 'L');
            $this->Cell($valueWidth, $lineHeight, $value, 0, 0, 'L');
            $startY += $lineHeight; // incrementam Y pentru urmatorul rand
        }
    }

    function SetDocTitleAndDate(string $title)
    {
        $this->AddFont('AvenisRegular', '', 'Avenis.php');
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');
        $this->SetY(80);
        $this->SetFont('AvenisSemibold', '', $this->FONT_SIZE_LARGE);
        $this->Cell(0, 10, $title, 0, 1, 'C');
        $this->SetFont('AvenisRegular', '', $this->FONT_SIZE_NORMAL);
        $this->Cell(0, 10, 'Data emiterii: ' . date('d-m-Y'), 0, 1, 'C');
    }

    function CreateTableHeader($header, $widths, $startX, $startY, $lineHeight)
    {
        $this->AddFont('AvenisRegular', '', 'Avenis.php');
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');

        //set double border
        $distanceBetweenLines = 1;
        $this->SetXY($startX, $startY);
        $this->SetDrawColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]); //border
        $this->Cell(array_sum($widths) + 2 * $distanceBetweenLines, $lineHeight + $distanceBetweenLines, '', 'L,T,R');

        //write header 
        $this->SetXY($startX + $distanceBetweenLines, $startY + $distanceBetweenLines);
        $this->SetFillColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]);
        $this->SetTextColor($this->WHITE[0], $this->WHITE[1], $this->WHITE[1]); // White text
        $this->SetDrawColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]); //border
        // $this->SetLineWidth(0.5);
        $this->SetFont('AvenisSemibold', '', $this->FONT_SIZE_SMALL);
        foreach ($header as $key => $col) {
            $this->Cell($widths[$key], $lineHeight, $col, 0, 0, 'C', true);
        }
        $this->Ln();
    }

    function FillTable($data, $widths, $startX, $startY, $lineHeight, $alignPositions)
    {
        $this->AddFont('AvenisRegular', '', 'Avenis.php');
        $this->AddFont('AvenisSemilight', '', 'Avenis-Semilight.php');
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');

        $this->SetFont('AvenisSemilight', '', $this->FONT_SIZE_SMALL);
        $this->SetTextColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]);
        $this->SetFillColor($this->WHITE[0], $this->WHITE[1], $this->WHITE[2]);

        $this->SetXY($startX, $startY);
        $total = 0;
        $rowIndex = 1;
        $emptyLnHeight = 2;
        $distanceBetweenLines = 1;

        foreach ($data as $row) {
            $maxHeight = 0;
            $cellHeights = [];
            $rowWithIndex = array_merge([$rowIndex++], $row);

            // determinam inaltimea fiecarei celule si cea mai mare inaltime din rand
            foreach ($rowWithIndex as $index => $cell) {
                // creează un MultiCell temporar pentru a calcula inaltimea
                $nbLines = $this->GetStringWidth($cell) / $widths[$index];
                $nbLines = ceil($nbLines);
                $height = $nbLines * $lineHeight;
                $cellHeights[] = $height;

                if ($height > $maxHeight) {
                    $maxHeight = $height;
                }
            }

            $currentX = $startX;
            // desenam fundalul pentru fiecare celula pe baza inaltimii maxime a randului
            foreach ($rowWithIndex as $index => $cell) {
                $this->SetXY($currentX, $startY);
                $this->Rect($currentX, $startY, $widths[$index], $maxHeight, 'F'); // Fundal
                $currentX += $widths[$index];
            }

            // scriem textul in celule
            $currentX = $startX; // resetam X la inceputul randului
            foreach ($rowWithIndex as $index => $cell) {
                $this->SetXY($currentX, $startY + ($maxHeight - $cellHeights[$index]) / 2); // centrare verticala
                $this->MultiCell($widths[$index], $lineHeight, $cell, 0, $alignPositions[$index]);
                $currentX += $widths[$index];
            }

            // desenam bordura dubla
            $leftBorderX = $startX - $distanceBetweenLines;
            $rightBorderX = $startX + array_sum($widths) + $distanceBetweenLines;
            $this->Line($leftBorderX, $startY, $leftBorderX, $startY + $maxHeight);
            $this->Line($rightBorderX, $startY, $rightBorderX, $startY + $maxHeight);

            // Avansam pe Y pentru urmatorul rand
            $startY += $maxHeight;

            $this->Ln($emptyLnHeight);
            //calculam totalul pentru penalizari (ultima coloana)
            $total += (float) end($row);
        }

        $this->SetXY($startX, $startY);
        $start = 0;
        $end = 10;
        for ($i = $start; $i < $end; $i++) {
            $this->Cell(array_sum($widths), $lineHeight, '', 0, 0, 'C', true);
            $this->Ln();
            $this->SetX($startX);
        }

        // desenam bordura dubla
        $leftBorderX = $startX - $distanceBetweenLines;
        $rightBorderX = $startX + array_sum($widths) + $distanceBetweenLines;
        $currentY = $startY;
        $this->Line($leftBorderX, $currentY, $leftBorderX, $currentY + $lineHeight * $end);
        $this->Line($rightBorderX, $currentY, $rightBorderX, $currentY + $lineHeight * $end);

        // Table Footer (Total)
        $currentY = $startY + $lineHeight * $end;
        $this->SetXY($startX, $currentY); //mutam cursorul la capatul ultimelor randuri din tabel
        $this->SetFont('AvenisSemibold', '', $this->FONT_SIZE_SMALL);
        $this->SetFillColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]);
        $this->SetTextColor($this->WHITE[0], $this->WHITE[1], $this->WHITE[2]);
        $this->SetDrawColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]);
        $this->SetLineWidth(0.5);
        $this->Cell(array_sum($widths) - $widths[count($widths) - $distanceBetweenLines], 2 * $lineHeight, 'Total', 'TB', 0, 'R', true);
        $this->Cell($widths[count($widths) - $distanceBetweenLines], 2 * $lineHeight, number_format($total, 2), 'TB', 0, 'C', true);
        $this->Ln(15);
        $this->SetLineWidth(0.2);

        // desenam bordura dubla pentru total
        $this->Line($leftBorderX, $currentY, $leftBorderX, $currentY + 2 * $lineHeight + $distanceBetweenLines);
        $this->Line($rightBorderX, $currentY, $rightBorderX, $currentY + 2 * $lineHeight + $distanceBetweenLines);
        $this->Line($leftBorderX, $currentY + 2 * $lineHeight + $distanceBetweenLines, $rightBorderX, $currentY + 2 * $lineHeight + $distanceBetweenLines);
        $this->Ln(10); //resetam X la capatul randului
    }

    function writeMessageAlert($pos, $width, $msg)
    {
        $this->SetXY($pos[0], $pos[1]);
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');
        $this->SetFont('AvenisSemibold', '', $this->FONT_SIZE_NORMAL + 2);
        $this->SetTextColor($this->DARK_BLUE[0], $this->DARK_BLUE[1], $this->DARK_BLUE[2]);
        $this->MultiCell($width, 5, $msg, 0, 'C');
    }

    // Page footer
    function Footer()
    {
        //place footer
        $this->SetY(-15);

        $this->AddFont('AvenisSemilight', '', 'Avenis-Semilight.php');
        $this->SetFont('AvenisSemilight', '', $this->FONT_SIZE_SMALL);

        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}
