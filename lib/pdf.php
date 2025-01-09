<?php
require_once __DIR__ . '/../module/fpdf/fpdf.php';


const FONT_SIZE_SMALL = 10;
const FONT_SIZE_NORMAL = 12;
const FONT_SIZE_LARGE = 20;
const DARK_BLUE = [26, 46, 73];
const WHITE = [255, 255, 255];
const LIGHT_YELLOW = [255, 252, 230];


class UserFeeListPDF extends FPDF
{
    function Header()
    {
        // background color
        $this->SetFillColor(LIGHT_YELLOW[0], LIGHT_YELLOW[1], LIGHT_YELLOW[2]);
        $this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F');

        //add new font
        $this->AddFont('AvenisRegular', '', 'Avenis.php');
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');

        // logo and library info (top left)
        $this->Image('../resurse/imagini/logo_mba_fara_scris.jpg', 10, 10, 20);
        $this->SetTextColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]);
        $this->SetXY(10, 32);
        $this->SetFont('AvenisSemibold', '', FONT_SIZE_SMALL);
        $this->MultiCell(0, 5, "Biblioteca MICA BUFNITA A ATENEI\nBulevardul Colinelor Intortocheate, nr. 7\nIasi, Romania", 0, 'L');
    }

    //set user information on top right
    function UserInfo(array $user)
    {
        $this->SetFont('AvenisRegular', '', FONT_SIZE_SMALL);
        // $this->SetXY(120, 40);
        $this->SetTextColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]);
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
        $this->SetFont('AvenisSemibold', '', FONT_SIZE_LARGE);
        $this->Cell(0, 10, $title, 0, 1, 'C');
        $this->SetFont('AvenisRegular', '', FONT_SIZE_NORMAL);
        $this->Cell(0, 10, 'Data emiterii: ' . date('d-m-Y'), 0, 1, 'C');
    }

    function CreateTableHeader($header,  $widths, $startX, $startY, $lineHeight)
    {
        $this->AddFont('AvenisRegular', '', 'Avenis.php');
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');
        //set double border
        $this->SetXY($startX, $startY);
        $this->SetDrawColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]); //border
        $this->Cell(array_sum($widths) + 2, 12, '', 'L,T,R');


        $this->SetY($startY + 1);
        $this->SetFillColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]);
        $this->SetTextColor(WHITE[0], WHITE[1], WHITE[1]); // White text
        $this->SetDrawColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]); //border
        // $this->SetLineWidth(0.5);
        $this->SetFont('AvenisSemibold', '', FONT_SIZE_SMALL);

        foreach ($header as $key => $col) {
            $this->Cell($widths[$key], $lineHeight, $col, 1, 0, 'C', true);
        }
        $this->Ln();
    }

    function FillTable($data, $widths, $startX, $startY, $lineHeight, $alignPositions)
    {
        $this->AddFont('AvenisRegular', '', 'Avenis.php');
        $this->AddFont('AvenisSemilight', '', 'Avenis-Semilight.php');
        $this->AddFont('AvenisSemibold', '', 'Avenis-Semibold.php');

        $this->SetFont('AvenisSemilight', '', FONT_SIZE_SMALL);
        $this->SetTextColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]);
        $this->SetFillColor(WHITE[0], WHITE[1], WHITE[2]);

        $this->SetXY($startX, $startY);
        $total = 0;
        $rowIndex = 1;

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
            $leftBorderX = $startX - 1;
            $rightBorderX = $startX + array_sum($widths) + 1;
            $this->Line($leftBorderX, $startY, $leftBorderX, $startY + $maxHeight);
            $this->Line($rightBorderX, $startY, $rightBorderX, $startY + $maxHeight);

            // Avansam pe Y pentru urmatorul rand
            $startY += $maxHeight;

            $this->Ln(2);

            $total += (float) end($row);
        }


        for ($i = 0; $i < 10; $i++) {
            $this->Cell(array_sum($widths), $lineHeight, '', 0, 0, 'C', true);
            $this->Ln($lineHeight);
        }

        // desenam bordura dubla
        $leftBorderX = $startX - 1;
        $rightBorderX = $startX + array_sum($widths) + 1;
        $currentY = $startY;
        for ($i = 0; $i < 10; $i++) {
            $this->Line($leftBorderX, $currentY, $leftBorderX, $currentY + $lineHeight);
            $this->Line($rightBorderX, $currentY, $rightBorderX, $currentY + $lineHeight);
            $currentY += $lineHeight;
        }
        // Table Footer (Total)
        $this->SetFont('AvenisSemibold', '', FONT_SIZE_SMALL);
        $this->SetFillColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]);
        $this->SetTextColor(WHITE[0], WHITE[1], WHITE[2]);
        $this->SetDrawColor(DARK_BLUE[0], DARK_BLUE[1], DARK_BLUE[2]);
        $this->SetLineWidth(0.5);
        $this->Cell(array_sum($widths) - $widths[count($widths) - 1], 2 * $lineHeight, 'Total', 'TB', 0, 'R', true);
        $this->Cell($widths[count($widths) - 1], 2 * $lineHeight, number_format($total, 2), 'TB', 0, 'C', true);
        $this->Ln(15);
        $this->SetLineWidth(0.2);
        // desenam bordura dubla pentru total
        $this->Line($leftBorderX, $currentY, $leftBorderX, $currentY + 2 * $lineHeight + 1);
        $this->Line($rightBorderX, $currentY, $rightBorderX, $currentY + 2 * $lineHeight + 1);
        $this->Line($leftBorderX, $currentY + 2 * $lineHeight + 1, $rightBorderX, $currentY + 2 * $lineHeight + 1);
        $this->Ln(15);
    }
}
